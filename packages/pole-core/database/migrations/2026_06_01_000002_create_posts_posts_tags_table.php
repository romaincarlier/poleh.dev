<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void {
        Schema::create( 'posts_posts_tags', function ( Blueprint $table ) : void {
            $table->id();
            $table->foreignId( 'post_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'post_tag_id' )->constrained( 'posts_tags' )->cascadeOnDelete();
            $table->timestamps();
        } );
    }

    public function down() : void {
        Schema::dropIfExists( 'posts_posts_tags' );
    }
};
