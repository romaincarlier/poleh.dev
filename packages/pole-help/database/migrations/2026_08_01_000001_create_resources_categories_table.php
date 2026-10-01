<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'resources_categories', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->text( 'excerpt' )->nullable();
            $table->longText( 'description' )->nullable();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->string( 'background_image' )->nullable();
            $table->string( 'illustration' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->json( 'resources' )->nullable();
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'resources_categories' )->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'resources_categories' );
    }
};
