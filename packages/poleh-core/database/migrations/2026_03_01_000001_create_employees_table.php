<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'employees', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->string( 'first_name' );
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->json( 'description' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'email' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'employees' );
    }
};
