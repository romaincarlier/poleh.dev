<?php
namespace Abacus;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

class AbacusPlugin implements Plugin {
    public static function make() : static {
        return app( static::class );
    }

    public function getId() : string {
        return 'abacus';
    }

    public function register( Panel $panel ) : void {
        $panel
            ->discoverResources( in: __DIR__ . '/Filament/Resources', for: 'Abacus\\Filament\\Resources' )
            ->discoverPages( in: __DIR__ . '/Filament/Pages', for: 'Abacus\\Filament\\Pages' )
            ->discoverClusters( in: __DIR__ . '/Filament/Clusters', for: 'Abacus\\Filament\\Clusters' )
            ->plugin( SpatieTranslatablePlugin::make()->defaultLocales( array_keys( config( 'abacus.locales' ) ) ) );
    }

    public function boot( Panel $panel ) : void {
        FilamentAsset::register( [
            Css::make( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css' ),
            Js::make( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js' )
        ], 'abacus-core' );
    }
}
