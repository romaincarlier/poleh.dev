<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-abacus::seo-tags :seo="$seo" />
    <x-abacus::breadcrumbs-json-ld :json="$breadcrumbs_json_ld" />

    {{-- Degrades gracefully instead of a hard crash if the front-end assets haven't been built yet. --}}
    @if ( file_exists( public_path( 'build/manifest.json' ) ) || file_exists( public_path( 'hot' ) ) )
        @vite( [ 'resources/css/app.css', 'resources/js/app.js' ] )
    @endif
</head>
<body>
    @php
        $notice_settings = app( \Abacus\Settings\Notice::class );
        $notice_visitor = app( \Abacus\Notices\Visitor::class );
    @endphp

    <x-abacus::notice :notice="$notice_settings" :should_show="$notice_visitor->should_show( $notice_settings )" />

    <x-abacus::menu position="prelude" />
    <x-abacus::menu position="header" />

    <main>
        @yield( 'content' )
    </main>

    <x-abacus::menu position="footer" />
    <x-abacus::menu position="legal" />
</body>
</html>
