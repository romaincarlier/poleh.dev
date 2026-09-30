@props( [ 'seo' ] )

<title>{{ $seo->title }}</title>

@if ( $seo->description )
    <meta name="description" content="{{ $seo->description }}">
@endif

@if ( $seo->keywords )
    <meta name="keywords" content="{{ $seo->keywords }}">
@endif

<meta name="robots" content="{{ $seo->robots ?? 'index, follow' }}">

<meta property="og:title" content="{{ $seo->og_title ?? $seo->title }}">

@if ( $seo->og_description ?? $seo->description )
    <meta property="og:description" content="{{ $seo->og_description ?? $seo->description }}">
@endif

@if ( $seo->og_image )
    <meta property="og:image" content="{{ $seo->og_image }}">
@endif

@if ( $seo->url )
    <meta property="og:url" content="{{ $seo->url }}">
@endif

<meta property="og:type" content="website">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo->og_title ?? $seo->title }}">

@if ( $seo->og_description ?? $seo->description )
    <meta name="twitter:description" content="{{ $seo->og_description ?? $seo->description }}">
@endif

@if ( $seo->og_image )
    <meta name="twitter:image" content="{{ $seo->og_image }}">
@endif
