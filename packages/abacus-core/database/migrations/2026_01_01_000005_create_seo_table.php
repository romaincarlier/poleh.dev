<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'seo', function ( Blueprint $table ) : void {
            $table->id();
            $table->morphs( 'seoable' );
            $table->json( 'meta_title' )->nullable();
            $table->json( 'meta_description' )->nullable();
            $table->json( 'meta_keywords' )->nullable();
            $table->json( 'meta_robots' )->nullable();
            $table->json( 'opengraph_title' )->nullable();
            $table->json( 'opengraph_description' )->nullable();
            $table->string( 'opengraph_image' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'seo' );
    }
};
