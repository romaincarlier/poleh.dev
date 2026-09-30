<?php
namespace Abacus\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use Kiritokatklian\LaravelColorPalette\Facades\ColorPalette as Palette;

/**
 * Expects the consuming model to also expose a media(): string method - HasMedia satisfies
 * this, but any model that can resolve its own image works.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method string media()
 */
trait HasColor {
    public function get_color_attribute() : string {
        $key = Str::lower( class_basename( $this ) ) . '_color_' . $this->id;

        if ( Cache::has( $key ) ) {
            return Cache::get( $key );
        }

        $value = Palette::getColor( $this->media() );
        Cache::forever( $key, $value );

        return $value;
    }
}
