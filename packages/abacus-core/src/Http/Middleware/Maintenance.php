<?php
namespace Abacus\Http\Middleware;

use Abacus\Settings\Maintenance as MaintenanceSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Maintenance {
    public function handle( Request $request, Closure $next ) : Response {
        $settings = app( MaintenanceSettings::class );

        if ( ! $settings->is_active ) {
            return $next( $request );
        }

        if ( Auth::guard( 'web' )->check() ) {
            return $next( $request );
        }

        if ( $request->routeIs( 'maintenance' ) ) {
            return $next( $request );
        }

        return response()->view( 'abacus::maintenance', [
            'title' => $settings->title[ app()->getLocale() ] ?? reset( $settings->title ) ?: null,
            'description' => $settings->description[ app()->getLocale() ] ?? reset( $settings->description ) ?: null,
            'end_time' => $settings->end_time
        ], 503 );
    }
}
