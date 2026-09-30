<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Additive, not an edit of the stock users migration: that migration already ran against
// the dev database, and rewriting it in place would require a migrate:fresh to take effect,
// which plan.txt explicitly forbids doing unsupervised. Every model gets SoftDeletes per
// plan.txt's project-wide rule, including User - this migration is how that reaches a table
// that was already created before this rule applied.
return new class extends Migration {
    public function up() : void {
        Schema::table( 'users', function ( Blueprint $table ) : void {
            $table->softDeletes();
        } );
    }

    public function down() : void {
        Schema::table( 'users', function ( Blueprint $table ) : void {
            $table->dropSoftDeletes();
        } );
    }
};
