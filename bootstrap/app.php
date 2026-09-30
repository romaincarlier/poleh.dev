<?php
use Abacus\Http\Exceptions\Expired;
use Abacus\Http\Middleware\Maintenance;
use Modules\Pole\Core\Http\Controllers\Errors;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure( basePath: dirname( __DIR__ ) )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware( function ( Middleware $middleware ) : void {
        $middleware->web( append: [
            Maintenance::class
        ] );
    } )
    ->withExceptions( function ( Exceptions $exceptions ) : void {
        $exceptions->shouldRenderJsonWhen(
            fn ( Request $request ) => $request->is( 'api/*' ) || $request->expectsJson()
        );

        $exceptions->render( fn ( NotFoundHttpException $exception, Request $request ) => response( app( Errors::class )->show(), 404 ) );

        $exceptions->render( function ( Expired $exception, Request $request ) {
            session()->flash( 'notice', __( 'This page or link has expired or moved. Please use the navigation menu or search to find what you were looking for.' ) );

            return response( app( Errors::class )->show(), 410 );
        } );
    } )->create();
