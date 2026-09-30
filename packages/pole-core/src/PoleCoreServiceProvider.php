<?php
namespace Modules\Pole\Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PoleCoreServiceProvider extends ServiceProvider {
    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'pole-core' );
        $this->loadTranslationsFrom( __DIR__ . '/../resources/lang', 'pole-core' );
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );

        Blade::componentNamespace( 'Modules\Pole\Core\\View\\Components', 'pole-core' );

        config( [
            'abacus.mailable_paths' => [
                ...config( 'abacus.mailable_paths', [] ),
                [ 'path' => __DIR__ . '/Mail', 'namespace' => 'Modules\Pole\Core\\Mail' ]
            ]
        ] );
    }
}
