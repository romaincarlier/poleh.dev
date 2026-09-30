<?php
namespace Abacus\Concerns;

use Abacus\Http\Exceptions\Expired;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property array $translatable
 * @property mixed $slug
 * @property string|null $slug_history
 * @method array getTranslations( string $key )
 */
trait HasComposedSlugs {
    public static function get_by_composed_slug( int | string $id, string $slug ) : ?static {
        $translatable = ( new static() )->translatable ?? [];

        if ( in_array( 'slug', $translatable ) ) {
            return static::where( 'id', $id )
                ->whereJsonContainsLocales( 'slug', array_keys( config( 'abacus.locales' ) ), $slug )
                ->first();
        }

        return static::where( 'id', $id )
            ->whereIn( 'slug', [ $slug, $id . '-' . $slug ] )
            ->first();
    }

    // Prefer this in controllers over get_by_composed_slug() when the address is user-visited -
    // distinguishes "never existed" (plain 404) from "used to exist, now retired" (a clearer
    // message for a non-technical visitor) by checking slug_history before giving up.
    public static function find_by_composed_slug_or_fail( int | string $id, string $slug ) : static {
        if ( $found = static::get_by_composed_slug( $id, $slug ) ) {
            return $found;
        }

        if ( static::slug_previously_existed( $id, $slug ) ) {
            throw new Expired();
        }

        abort( 404 );
    }

    protected static function slug_previously_existed( int | string $id, string $slug ) : bool {
        $record = static::withTrashed()->find( $id );

        if ( ! $record || empty( $record->slug_history ) ) {
            return false;
        }

        return in_array( $slug, json_decode( $record->slug_history, true ) ?: [], true );
    }

    public function resolveRouteBinding( $value, $field = null ) : ?static {
        $field = $field ?: $this->getRouteKeyName();

        if ( 'slug' === $field && in_array( 'slug', $this->translatable ?? [] ) ) {
            $field .= '->' . App::getLocale();
        }

        return $this->where( $field, $value )->firstOrFail();
    }

    public static function bootHasComposedSlugs() : void {
        static::updated( function ( $model ) : void {
            if ( ! static::has_slug_history_column( $model ) || ! $model->wasChanged( 'slug' ) ) {
                return;
            }

            $slugs = in_array( 'slug', $model->translatable ?? [] )
                ? array_values( (array) $model->getTranslations( 'slug' ) )
                : [ $model->getOriginal( 'slug' ) ];

            $history = json_decode( $model->slug_history ?? '', true ) ?: [];
            $history = array_values( array_unique( array_filter( array_merge( $history, $slugs ) ) ) );

            $model->slug_history = json_encode( $history, JSON_UNESCAPED_SLASHES );
            $model->saveQuietly();
        } );
    }

    protected static array $has_slug_history_column = [];

    protected static function has_slug_history_column( $model ) : bool {
        $table = $model->getTable();

        return static::$has_slug_history_column[ $table ] ??= Schema::hasColumn( $table, 'slug_history' );
    }

    public static function regenerate_slug( $title ) : string | array {
        return is_array( $title )
            ? array_map( fn ( $value ) => Str::slug( $value ), $title )
            : Str::slug( $title );
    }
}
