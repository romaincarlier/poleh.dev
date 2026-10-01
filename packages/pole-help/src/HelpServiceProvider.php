<?php
namespace Modules\Pole\Help;

use Illuminate\Support\ServiceProvider;

class HelpServiceProvider extends ServiceProvider {
    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'pole-help' );
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php' );
    }
}
