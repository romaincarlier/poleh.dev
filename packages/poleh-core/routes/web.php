<?php
use Illuminate\Support\Facades\Route;
use Modules\PoleH\Core\Http\Controllers\Index;

Route::get( '/', Index::class )->name( 'home' );
