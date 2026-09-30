<?php

return [

    // Locales available for translatable ("Polyglot") fields. Keyed by locale code.
    // A single entry collapses Polyglot fields to a plain Group (no language switcher).
    'locales' => [
        'fr' => 'Français'
    ],

    // Optional closure( int $page_id ) : ?string - resolves a menu item's linked "page" id to a URL.
    // Left null until a Page model exists; menu items can still link via a named route or a raw URL.
    'menu_page_resolver' => null,

    // Directories scanned for Filament RichEditor custom blocks (Abacus\Filament\Blocks\Block subclasses).
    // Each entry pairs the directory with the namespace its classes live under.
    'block_paths' => [
        [ 'path' => app_path( 'Filament/Blocks' ), 'namespace' => 'App\\Filament\\Blocks' ]
    ],

    // Directories scanned for Previewable Mailables/Notifications shown on the Emails admin page.
    // Each entry pairs the directory with the namespace its classes live under.
    'mailable_paths' => [
        [ 'path' => app_path( 'Mail' ), 'namespace' => 'App\\Mail' ],
        [ 'path' => app_path( 'Notifications' ), 'namespace' => 'App\\Notifications' ]
    ]

];
