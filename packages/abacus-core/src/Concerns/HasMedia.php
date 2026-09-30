<?php
namespace Abacus\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * @property string|null $media
 * @property string|null $thumbnail
 */
trait HasMedia {
    public function media() : string {
        if ( ! empty( $this->media ) && Storage::disk( 'public' )->exists( ltrim( $this->media, '/' ) ) ) {
            return Storage::disk( 'public' )->url( ltrim( $this->media, '/' ) );
        }

        if ( Storage::disk( 'public' )->exists( 'images/default/media/' . get_class( $this ) . '.png' ) ) {
            return Storage::disk( 'public' )->url( 'images/default/media/' . get_class( $this ) . '.png' );
        }

        return Storage::disk( 'public' )->url( 'images/default/media/default.png' );
    }

    public function thumbnail() : string {
        if ( ! empty( $this->thumbnail ) && Storage::disk( 'public' )->exists( ltrim( $this->thumbnail, '/' ) ) ) {
            return Storage::disk( 'public' )->url( ltrim( $this->thumbnail, '/' ) );
        }

        if ( Storage::disk( 'public' )->exists( 'images/default/thumbnail/' . get_class( $this ) . '.png' ) ) {
            return Storage::disk( 'public' )->url( 'images/default/thumbnail/' . get_class( $this ) . '.png' );
        }

        return Storage::disk( 'public' )->url( 'images/default/thumbnail/default.png' );
    }

    public function get_media_filename( string $member = 'media' ) : string | false {
        if ( ! empty( $this->{$member} ) && is_string( $this->{$member} ) ) {
            return $this->{$member};
        }

        return false;
    }
}
