<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'menu_menu_position', function ( Blueprint $table ) : void {
            $table->id();
            $table->foreignId( 'menu_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'menu_position_id' )->constrained()->cascadeOnDelete();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->timestamps();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'menu_menu_position' );
    }
};
