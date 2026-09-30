<?php
namespace Abacus\Concerns;

use Illuminate\Support\Facades\Schema;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property int|null $parent_id
 */
trait HasParents {
    public $ancestor_count = 0;

    public function parent() {
        if ( ! $this->parent_id ) {
            return 0;
        }

        return static::find( $this->parent_id );
    }

    public function ancestors() : int {
        $this->ancestor_count = 0;
        $node = $this;

        while ( $parent = $node->parent() ) {
            $this->ancestor_count += 1;
            $node = $parent;
        }

        return $this->ancestor_count;
    }

    public static function nested( int $parent_id = 0, ?string $sort = null ) : array {
        $columns = array_filter( [ 'id', 'parent_id', $sort ] );
        $records = static::query()->get( $columns )->sortByDesc( 'id' )->groupBy( 'parent_id' )->sortBy( 'parent_id' )->toArray();

        // A null parent_id groups under an empty string key, not 0 - normalize it.
        foreach ( $records as $parent => $children ) {
            if ( '' !== (string) $parent ) {
                continue;
            }

            $records[ 0 ] = $children;
            unset( $records[ $parent ] );
        }

        if ( ! empty( $sort ) && Schema::hasColumn( ( new static() )->getTable(), $sort ) ) {
            foreach ( array_keys( $records ) as $key ) {
                uasort( $records[ $key ], fn ( $a, $b ) => ( $a[ $sort ] <=> $b[ $sort ] ) ?: ( $a[ 'id' ] <=> $b[ 'id' ] ) );
            }
        }

        return static::nested_from( $records, $parent_id );
    }

    protected static function nested_from( array $records, int $parent_id ) : array {
        $ids = [];

        foreach ( $records[ $parent_id ] ?? [] as $item ) {
            $ids[] = $item[ 'id' ];

            if ( ! empty( $records[ $item[ 'id' ] ] ) ) {
                array_push( $ids, ...static::nested_from( $records, $item[ 'id' ] ) );
            }
        }

        return $ids;
    }
}
