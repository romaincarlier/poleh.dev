<?php
namespace Modules\Pole\PTJS;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PTJSServiceProvider extends ServiceProvider {
    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'pole-ptjs' );
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );

        Blade::componentNamespace( 'Modules\Pole\PTJS\\View\\Components', 'pole-ptjs' );
    }
}
