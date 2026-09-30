<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'definitions', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'term' );
            $table->text( 'description' )->nullable();
            $table->string( 'acronym' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'definitions' );
    }
};
