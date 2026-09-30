<?php
namespace Modules\PoleH\Core;

use Filament\Contracts\Plugin;
use Filament\Panel;

class PolehCorePlugin implements Plugin {
    public static function make() : static {
        return app( static::class );
    }

    public function getId() : string {
        return 'poleh-core';
    }

    public function register( Panel $panel ) : void {
        $panel
            ->discoverResources( in: __DIR__ . '/Filament/Resources', for: 'Modules\\PoleH\\Core\\Filament\\Resources' )
            ->discoverClusters( in: __DIR__ . '/Filament/Clusters', for: 'Modules\\PoleH\\Core\\Filament\\Clusters' );

        config([
            'abacus.block_paths' => [
                ...config( 'abacus.block_paths', [] ),
                [ 'path' => __DIR__ . '/Filament/Blocks', 'namespace' => 'Modules\\PoleH\\Core\\Filament\\Blocks' ]
            ]
        ]);
    }

    public function boot( Panel $panel ) : void {
        //
    }
}
