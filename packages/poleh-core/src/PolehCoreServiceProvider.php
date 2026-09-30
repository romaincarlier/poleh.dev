<?php
namespace Modules\PoleH\Core;

use Illuminate\Support\ServiceProvider;

class PolehCoreServiceProvider extends ServiceProvider {
    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'poleh-core' );
        $this->loadTranslationsFrom( __DIR__ . '/../resources/lang', 'poleh-core' );
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );
    }
}
