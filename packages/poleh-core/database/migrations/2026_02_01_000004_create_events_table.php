<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'events', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->text( 'excerpt' )->nullable();
            $table->longText( 'description' )->nullable();
            $table->longText( 'practical_information' )->nullable();
            $table->string( 'info_url' )->nullable();
            $table->string( 'registration_url' )->nullable();

            $table->string( 'address_street' )->nullable();
            $table->string( 'address_number' )->nullable();
            $table->string( 'address_postal_code' )->nullable();
            $table->string( 'address_city' )->nullable();
            $table->string( 'address_country' )->nullable();
            $table->decimal( 'address_latitude', 10, 7 )->nullable();
            $table->decimal( 'address_longitude', 10, 7 )->nullable();

            $table->string( 'custom_location' )->nullable();
            $table->string( 'organizer_name' )->nullable();
            $table->string( 'organizer_email' )->nullable();
            $table->dateTime( 'event_date' )->nullable();
            $table->string( 'human_date' )->nullable();
            $table->string( 'image' )->nullable();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->decimal( 'price', 8, 2 )->nullable();
            $table->boolean( 'is_featured' )->default( false );
            $table->boolean( 'is_poster' )->default( false );

            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'events' );
    }
};
