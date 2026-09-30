<?php
namespace Abacus;

use Abacus\Console\Commands\Settings as SettingsCommand;
use Abacus\Http\Middleware\Maintenance as MaintenanceMiddleware;
use Abacus\Menu\Models\Item;
use Abacus\Menu\Models\Menu;
use Abacus\Menu\Models\MenuPosition;
use Abacus\Settings\Email;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AbacusServiceProvider extends ServiceProvider {
    public function register() : void {
        $this->mergeConfigFrom( __DIR__ . '/../config/abacus.php', 'abacus' );
    }

    public function boot() : void {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'abacus' );
        $this->loadTranslationsFrom( __DIR__ . '/../resources/lang', 'abacus' );

        Blade::componentNamespace( 'Abacus\\Menu\\View\\Components', 'abacus' );

        $this->app[ Router::class ]->aliasMiddleware( 'maintenance', MaintenanceMiddleware::class );

        if ( $this->app->runningInConsole() ) {
            $this->commands( [ SettingsCommand::class ] );
        }

        $this->bust_menu_cache_on_write();
        $this->suppress_mail_when_disabled();
    }

    protected function bust_menu_cache_on_write() : void {
        $forget_all_positions = function () : void {
            MenuPosition::pluck( 'slug' )->each( fn ( $slug ) => Cache::forget( 'abacus.menu.position.' . $slug ) );
        };

        foreach ( [ Menu::class, Item::class, MenuPosition::class ] as $model ) {
            $model::saved( $forget_all_positions );
            $model::deleted( $forget_all_positions );
        }
    }

    protected function suppress_mail_when_disabled() : void {
        Event::listen( MessageSending::class, function ( MessageSending $event ) : bool {
            if ( ! app( Email::class )->is_sending_disabled ) {
                return true;
            }

            Log::info( 'Outgoing email suppressed (global toggle active): ' . $event->message->getSubject() );

            return false;
        } );
    }
}
