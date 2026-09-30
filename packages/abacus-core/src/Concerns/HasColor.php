<?php
namespace Abacus\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Expects the consuming model to also use HasMedia (for media_source()/media()) - any model
 * that can resolve its own image, local path preferred, works.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method string media()
 * @method string|null media_source()
 */
trait HasColor {
    public function get_color_attribute() : string {
        $key = Str::lower( class_basename( $this ) ) . '_color_' . $this->id;

        if ( Cache::has( $key ) ) {
            return Cache::get( $key );
        }

        $source = method_exists( $this, 'media_source' ) ? ( $this->media_source() ?? $this->media() ) : $this->media();
        $value = static::extract_dominant_color( $source );
        Cache::forever( $key, $value );

        return $value;
    }

    protected static function extract_dominant_color( string $source ) : string {
        $contents = @file_get_contents( $source );
        $image = $contents ? @imagecreatefromstring( $contents ) : false;

        if ( ! $image ) {
            return '#000000';
        }

        $resized = imagescale( $image, 1, 1 );
        $rgb = imagecolorsforindex( $resized, imagecolorat( $resized, 0, 0 ) );

        return sprintf( '#%02x%02x%02x', $rgb['red'], $rgb['green'], $rgb['blue'] );
    }
}
