<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'events_events_categories', function ( Blueprint $table ) : void {
            $table->id();
            $table->foreignId( 'event_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'event_category_id' )->constrained( 'events_categories' )->cascadeOnDelete();
            $table->timestamps();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'events_events_categories' );
    }
};
