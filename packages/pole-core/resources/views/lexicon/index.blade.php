@extends( 'pole-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
        $title = $settings->lexicon_title[ $locale ] ?? reset( $settings->lexicon_title ) ?: __( 'Lexicon' );
        $content = $settings->lexicon_content[ $locale ] ?? reset( $settings->lexicon_content );
    @endphp

    <section style="border: 4px solid #0d9488;">
        <h1>{{ $title }}</h1>

        @if ( $content )
            <div>{!! $content !!}</div>
        @endif

        @forelse ( $definitions_by_letter as $letter => $definitions )
            <details>
                <summary>{{ $letter }}</summary>

                <dl>
                    @foreach ( $definitions as $definition )
                        <dt>
                            {{ $definition->term }}

                            @if ( $definition->acronym )
                                <span>({{ $definition->acronym }})</span>
                            @endif
                        </dt>

                        @if ( $definition->description )
                            <dd>{{ $definition->description }}</dd>
                        @endif
                    @endforeach
                </dl>
            </details>
        @empty
            <p>{{ __( 'No definitions yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
