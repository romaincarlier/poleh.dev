<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::table( 'partners', function ( Blueprint $table ) : void {
            $table->foreignId( 'partner_category_id' )->nullable()->after( 'excerpt' )->constrained( 'partners_categories' )->nullOnDelete();
            $table->text( 'collaboration' )->nullable()->after( 'partner_category_id' );
            $table->string( 'email' )->nullable()->after( 'collaboration' );
            $table->string( 'phone' )->nullable()->after( 'email' );

            $this->address( $table, 'headquarters' );
            $this->address( $table, 'hainaut' );
        } );
    }

    protected function address( Blueprint $table, string $prefix ) : void {
        $table->string( $prefix . '_street' )->nullable();
        $table->string( $prefix . '_number' )->nullable();
        $table->string( $prefix . '_postal_code' )->nullable();
        $table->string( $prefix . '_city' )->nullable();
        $table->string( $prefix . '_country' )->nullable();
        $table->decimal( $prefix . '_latitude', 10, 7 )->nullable();
        $table->decimal( $prefix . '_longitude', 10, 7 )->nullable();
    }

    public function down() : void {
        Schema::table( 'partners', function ( Blueprint $table ) : void {
            $table->dropConstrainedForeignId( 'partner_category_id' );
            $table->dropColumn( [
                'collaboration', 'email', 'phone',
                'headquarters_street', 'headquarters_number', 'headquarters_postal_code', 'headquarters_city', 'headquarters_country', 'headquarters_latitude', 'headquarters_longitude',
                'hainaut_street', 'hainaut_number', 'hainaut_postal_code', 'hainaut_city', 'hainaut_country', 'hainaut_latitude', 'hainaut_longitude'
            ] );
        } );
    }
};
