<?php
namespace Abacus\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use Kiritokatklian\LaravelColorPalette\Facades\ColorPalette as Palette;

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
        $value = Palette::getColor( $source );
        Cache::forever( $key, $value );

        return $value;
    }
}
