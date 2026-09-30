@extends( 'poleh-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
        $title = $settings->error_title[ $locale ] ?? reset( $settings->error_title ) ?: __( 'Page not found.' );
        $content = $settings->error_content[ $locale ] ?? reset( $settings->error_content );
    @endphp

    <section style="border: 4px solid #6b7280;">
        @if ( $settings->error_image )
            <picture>
                @if ( $settings->error_image_mobile )
                    <source media="(max-width: 640px)" srcset="{{ asset( 'storage/' . $settings->error_image_mobile ) }}">
                @endif
                <img src="{{ asset( 'storage/' . $settings->error_image ) }}" alt="">
            </picture>
        @endif

        <h1>{{ $title }}</h1>

        @if ( session( 'notice' ) )
            <p>{{ session( 'notice' ) }}</p>
        @elseif ( $content )
            <div>{!! $content !!}</div>
        @endif
    </section>

    <x-poleh-core::categories.portals />
    <x-poleh-core::partners.listing />
    <x-poleh-core::call.help />
@endsection
