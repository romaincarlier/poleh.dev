<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?: __( 'Site under maintenance' ) }}</title>
</head>
<body>
    <main style="max-width: 40rem; margin: 10vh auto; text-align: center; font-family: sans-serif;">
        <h1>{{ $title ?: __( 'Site under maintenance' ) }}</h1>

        @if ( $description )
            <div>{!! $description !!}</div>
        @endif

        @if ( $end_time && $end_time->isFuture() )
            <p>{{ __( 'Expected back online around :time.', [ 'time' => $end_time->translatedFormat( 'd/m/Y H:i' ) ] ) }}</p>
        @endif
    </main>
</body>
</html>
