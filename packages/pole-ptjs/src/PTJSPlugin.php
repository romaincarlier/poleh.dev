<?php
namespace Modules\Pole\PTJS;

use Filament\Contracts\Plugin;
use Filament\Panel;

class PTJSPlugin implements Plugin {
    public static function make() : static {
        return app( static::class );
    }

    public function getId() : string {
        return 'pole-ptjs';
    }

    public function register( Panel $panel ) : void {
        $panel
            ->discoverResources( in: __DIR__ . '/Filament/Resources', for: 'Modules\Pole\PTJS\\Filament\\Resources' )
            ->discoverClusters( in: __DIR__ . '/Filament/Clusters', for: 'Modules\Pole\PTJS\\Filament\\Clusters' );
    }

    public function boot( Panel $panel ) : void {
        //
    }
}
