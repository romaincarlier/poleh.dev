<?php
use Modules\Pole\PTJS\Http\Controllers\Index;
use Modules\Pole\PTJS\Http\Controllers\Show;

use Illuminate\Support\Facades\Route;

// loadRoutesFrom() does not apply the "web" middleware group by itself - routes loaded from a
// package service provider need it wrapped explicitly, unlike the app's own routes/web.php.
Route::middleware( 'web' )->group( function () : void {
    Route::get( '/plustardjeserai', Index::class )->name( 'ptjs.index' );
    Route::get( '/plustardjeserai/{id}/{slug?}', Show::class )->where( 'id', '[0-9]+' )->name( 'ptjs.show' );
} );
