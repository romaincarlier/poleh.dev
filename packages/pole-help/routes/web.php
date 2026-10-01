<?php
use Modules\Pole\Help\Http\Controllers\Index;
use Modules\Pole\Help\Http\Controllers\Show;

use Illuminate\Support\Facades\Route;

// loadRoutesFrom() does not apply the "web" middleware group by itself - routes loaded from a
// package service provider need it wrapped explicitly, unlike the app's own routes/web.php.
Route::middleware( 'web' )->group( function () : void {
    Route::get( '/aide-et-precarite', Index::class )->name( 'help.index' );
    Route::get( '/aide-et-precarite/{id}/{slug?}', Show::class )->where( 'id', '[0-9]+' )->name( 'help.show' );
} );
