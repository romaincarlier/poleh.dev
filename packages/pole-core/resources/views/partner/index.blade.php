@extends( 'pole-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
        $title = $settings->partner_title[ $locale ] ?? reset( $settings->partner_title ) ?: __( 'Partners' );
        $content = $settings->partner_content[ $locale ] ?? reset( $settings->partner_content );
        $postlude_title = $settings->partner_postlude_title[ $locale ] ?? reset( $settings->partner_postlude_title );
        $postlude_content = $settings->partner_postlude_content[ $locale ] ?? reset( $settings->partner_postlude_content );
    @endphp

    <section style="border: 4px solid #f97316;">
        <h1>{{ $title }}</h1>

        @if ( $content )
            <div>{!! $content !!}</div>
        @endif

        @forelse ( $categories as $category )
            <article>
                <h2>{{ $category->name }}</h2>

                @if ( $category->excerpt )
                    <p>{{ $category->excerpt }}</p>
                @endif
            </article>
        @empty
            <p>{{ __( 'No partner categories yet.' ) }}</p>
        @endforelse

        @forelse ( $partners as $partner )
            <details>
                <summary>
                    @if ( $partner->logo )
                        <img src="{{ asset( 'storage/' . $partner->logo ) }}" alt="{{ $partner->name }}">
                    @endif

                    {{ $partner->name }}
                </summary>

                @if ( $partner->headquarters_street )
                    <p>
                        {{ __( 'Registered office' ) }}:
                        {{ $partner->headquarters_street }} {{ $partner->headquarters_number }},
                        {{ $partner->headquarters_postal_code }} {{ $partner->headquarters_city }}
                    </p>
                @endif

                @if ( $partner->hainaut_street )
                    <p>
                        {{ __( 'Hainaut address' ) }}:
                        {{ $partner->hainaut_street }} {{ $partner->hainaut_number }},
                        {{ $partner->hainaut_postal_code }} {{ $partner->hainaut_city }}
                    </p>
                @endif

                @if ( $partner->collaboration )
                    <div>{!! $partner->collaboration !!}</div>
                @endif

                @if ( $partner->email )
                    <p><a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a></p>
                @endif

                @if ( $partner->phone )
                    <p>{{ $partner->phone }}</p>
                @endif
            </details>
        @empty
            <p>{{ __( 'No partners yet.' ) }}</p>
        @endforelse

        @if ( $postlude_title || $postlude_content )
            <div>
                @if ( $postlude_title )
                    <h2>{{ $postlude_title }}</h2>
                @endif

                @if ( $postlude_content )
                    <div>{!! $postlude_content !!}</div>
                @endif
            </div>
        @endif
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
