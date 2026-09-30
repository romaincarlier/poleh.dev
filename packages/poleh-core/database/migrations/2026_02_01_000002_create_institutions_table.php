<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'institutions', function ( Blueprint $table ) : void {
            $table->id();
            $table->string( 'name' );
            $table->string( 'logo' )->nullable();
            $table->text( 'excerpt' )->nullable();
            $table->longText( 'description' )->nullable();
            $table->string( 'website_url' )->nullable();
            $table->boolean( 'show_in_list' )->default( true );
            $table->foreignId( 'institution_category_id' )->nullable()->constrained( 'institutions_categories' )->nullOnDelete();
            $table->string( 'slug' );
            $table->string( 'slug_history' )->nullable();
            $table->unsignedInteger( 'order' )->default( 0 );

            $this->address( $table, 'primary' );
            $this->address( $table, 'hainaut' );

            $table->string( 'meta_title' )->nullable();
            $table->string( 'meta_description' )->nullable();
            $table->string( 'meta_keywords' )->nullable();
            $table->string( 'meta_robots' )->nullable();
            $table->string( 'opengraph_title' )->nullable();
            $table->string( 'opengraph_description' )->nullable();
            $table->string( 'opengraph_image' )->nullable();
            $table->string( 'breadcrumb_title' )->nullable();
            $table->string( 'redirect' )->nullable();

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists( 'institutions' );
    }
};
