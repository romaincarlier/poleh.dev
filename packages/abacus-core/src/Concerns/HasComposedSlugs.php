<?php
namespace Abacus\Concerns;

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
