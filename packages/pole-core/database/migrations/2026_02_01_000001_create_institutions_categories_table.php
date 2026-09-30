<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'institutions_categories', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->string( 'plural_name' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->text( 'description' )->nullable();
            $table->text( 'excerpt' )->nullable();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'institutions_categories' )->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'institutions_categories' );
    }
};
