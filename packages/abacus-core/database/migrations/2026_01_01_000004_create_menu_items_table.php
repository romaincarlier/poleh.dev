<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'menu_items', function ( Blueprint $table ) : void {
            $table->id();
            $table->foreignId( 'menu_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'menu_items' )->nullOnDelete();
            $table->json( 'label' );
            $table->json( 'url' )->nullable();
            $table->json( 'link_title' )->nullable();
            $table->string( 'route' )->nullable();
            $table->unsignedBigInteger( 'page' )->nullable();
            $table->string( 'link_target' )->nullable();
            $table->string( 'link_relationship' )->nullable();
            $table->string( 'class' )->nullable();
            $table->boolean( 'is_active' )->default( true );
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'menu_items' );
    }
};
