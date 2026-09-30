<?php
use Modules\Pole\Core\Http\Controllers\Contact;
use Modules\Pole\Core\Http\Controllers\Event;
use Modules\Pole\Core\Http\Controllers\Faq;
use Modules\Pole\Core\Http\Controllers\Index;
use Modules\Pole\Core\Http\Controllers\Lexicon;

use Illuminate\Support\Facades\Route;

// loadRoutesFrom() does not apply the "web" middleware group by itself - routes loaded from a
// package service provider need it wrapped explicitly, unlike the app's own routes/web.php.
Route::middleware( 'web' )->group( function () : void {
    Route::get( '/', Index::class )->name( 'home' );

    Route::get( '/contact', [ Contact::class, 'index' ] )->name( 'contact.index' );
    Route::post( '/contact', [ Contact::class, 'store' ] )->name( 'contact.store' );

    Route::get( '/agenda', Event\Index::class )->name( 'event.index' );
    Route::get( '/agenda/{id}/{slug?}', Event\Show::class )->where( 'id', '[0-9]+' )->name( 'event.show' );

    Route::get( '/lexicon', Lexicon::class )->name( 'lexicon.index' );

    Route::get( '/faq', Faq\Index::class )->name( 'faq.index' );
    Route::get( '/faq/{glossary}', Faq\Show::class )->name( 'faq.show' );
} );
