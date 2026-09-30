<?php
namespace Modules\PoleH\Core\Models;

use Abacus\Concerns\HasComposedSlugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Partner extends Model {
    use HasComposedSlugs, SoftDeletes;

    protected $guarded = [];

    public function recolored_logo( string $color = 'black' ) : ?string {
        if ( ! $this->logo_vector || ! Storage::disk( 'public' )->exists( $this->logo_vector ) ) {
            return null;
        }

        $svg = Storage::disk( 'public' )->get( $this->logo_vector );
        $hex = 'black' === $color ? '#000000' : '#ffffff';

        if ( preg_match( '/fill="[^"]*"/i', $svg ) ) {
            return preg_replace( '/fill="[^"]*"/i', 'fill="' . $hex . '"', $svg, 1 );
        }

        return str_replace( '<svg ', '<svg fill="' . $hex . '" ', $svg );
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
