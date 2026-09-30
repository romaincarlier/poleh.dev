<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'questions', function ( Blueprint $table ) : void {
            $table->id();
            $table->foreignId( 'glossary_id' )->constrained()->cascadeOnDelete();
            $table->json( 'question' );
            $table->json( 'answer' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'questions' );
    }
};
