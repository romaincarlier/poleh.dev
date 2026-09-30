<?php
use Modules\PoleH\Core\Http\Controllers\Contact;
use Modules\PoleH\Core\Http\Controllers\Event;
use Modules\PoleH\Core\Http\Controllers\Index;

use Illuminate\Support\Facades\Route;

// loadRoutesFrom() does not apply the "web" middleware group by itself - routes loaded from a
// package service provider need it wrapped explicitly, unlike the app's own routes/web.php.
Route::middleware( 'web' )->group( function () : void {
    Route::get( '/', Index::class )->name( 'home' );

    Route::get( '/contact', [ Contact::class, 'index' ] )->name( 'contact.index' );
    Route::post( '/contact', [ Contact::class, 'store' ] )->name( 'contact.store' );

    Route::get( '/agenda', Event\Index::class )->name( 'event.index' );
    Route::get( '/agenda/{id}/{slug?}', Event\Show::class )->where( 'id', '[0-9]+' )->name( 'event.show' );
} );
