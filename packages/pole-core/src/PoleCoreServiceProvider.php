<?php
namespace Modules\PoleH\Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PolehCoreServiceProvider extends ServiceProvider {
    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'poleh-core' );
        $this->loadTranslationsFrom( __DIR__ . '/../resources/lang', 'poleh-core' );
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );

        Blade::componentNamespace( 'Modules\\PoleH\\Core\\View\\Components', 'poleh-core' );

        config( [
            'abacus.mailable_paths' => [
                ...config( 'abacus.mailable_paths', [] ),
                [ 'path' => __DIR__ . '/Mail', 'namespace' => 'Modules\\PoleH\\Core\\Mail' ]
            ]
        ] );
    }
}
