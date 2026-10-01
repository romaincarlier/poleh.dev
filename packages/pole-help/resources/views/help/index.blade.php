@extends( 'pole-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
        $title = $settings->title[ $locale ] ?? reset( $settings->title ) ?: __( 'Aide & Precarite' );
        $introduction = $settings->introduction[ $locale ] ?? reset( $settings->introduction );
    @endphp

    <section style="border: 4px solid #0d9488;">
        <h1>{{ $title }}</h1>

        @if ( $introduction )
            <div>{!! $introduction !!}</div>
        @endif

        @if ( $settings->video_url )
            <a href="{{ $settings->video_url }}">{{ __( 'Watch the presentation video' ) }}</a>
        @endif
    </section>

    <section style="border: 4px solid #6366f1;">
        @forelse ( $categories as $category )
            <article>
                @if ( $category->background_image )
                    <img src="{{ asset( 'storage/' . $category->background_image ) }}" alt="">
                @endif

                @if ( $category->illustration )
                    <img src="{{ asset( $category->illustration->svg_path() ) }}" alt="">
                @endif

                <h2>{{ $category->name }}</h2>

                @if ( $category->excerpt )
                    <p>{{ $category->excerpt }}</p>
                @endif

                <a href="{{ route( 'help.show', $category->route_parameters() ) }}" title="{{ __( 'Discover :name', [ 'name' => $category->name ] ) }}">
                    {{ __( 'Discover' ) }}
                </a>
            </article>
        @empty
            <p>{{ __( 'No resource categories published yet.' ) }}</p>
        @endforelse
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
