<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'partners', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->string( 'logo' )->nullable();
            $table->string( 'logo_vector' )->nullable();
            $table->string( 'destination_url' )->nullable();
            $table->text( 'description' )->nullable();
            $table->text( 'excerpt' )->nullable();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'partners' );
    }
};
