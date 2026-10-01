<?php
namespace Modules\Pole\Help;

use Filament\Contracts\Plugin;
use Filament\Panel;

class HelpPlugin implements Plugin {
    public static function make() : static {
        return app( static::class );
    }

    public function getId() : string {
        return 'pole-help';
    }

    public function register( Panel $panel ) : void {
        $panel
            ->discoverResources( in: __DIR__ . '/Filament/Resources', for: 'Modules\Pole\Help\\Filament\\Resources' )
            ->discoverClusters( in: __DIR__ . '/Filament/Clusters', for: 'Modules\Pole\Help\\Filament\\Clusters' );
    }

    public function boot( Panel $panel ) : void {
        //
    }
}
