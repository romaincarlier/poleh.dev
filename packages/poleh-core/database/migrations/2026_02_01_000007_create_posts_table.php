<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'posts', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'title' );
            $table->text( 'excerpt' )->nullable();
            $table->longText( 'content' )->nullable();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->boolean( 'is_published' )->default( false );
            $table->string( 'media' )->nullable();
            $table->string( 'thumbnail' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->foreignId( 'author_id' )->nullable()->constrained( 'users' )->nullOnDelete();

            $table->string( 'meta_title' )->nullable();
            $table->string( 'meta_description' )->nullable();
            $table->string( 'meta_keywords' )->nullable();
            $table->string( 'meta_robots' )->nullable();
            $table->string( 'opengraph_title' )->nullable();
            $table->string( 'opengraph_description' )->nullable();
            $table->string( 'opengraph_image' )->nullable();
            $table->string( 'breadcrumb_title' )->nullable();
            $table->string( 'redirect' )->nullable();

            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'posts' );
    }
};
