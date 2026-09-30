<?php
namespace Abacus\Menu\Models;

use Abacus\Concerns\HasParents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use Spatie\Translatable\HasTranslations;

class Item extends Model {
    use HasParents, HasTranslations, SoftDeletes;

    protected $table = 'menu_items';
    protected $guarded = [];

    public array $translatable = [ 'label', 'url', 'link_title' ];

    protected $casts = [ 'is_active' => 'boolean' ];

    public function menu() : BelongsTo {
        return $this->belongsTo( Menu::class );
    }

    public function children() : HasMany {
        return $this->hasMany( self::class, 'parent_id' )->orderBy( 'order' );
    }

    public static function destination( self $item ) : string {
        if ( $item->route && Route::has( $item->route ) ) {
            return route( $item->route, [], false );
        }

        if ( $item->page ) {
            $resolver = config( 'abacus.menu_page_resolver' );
            $resolved = $resolver ? $resolver( $item->page ) : null;

            if ( $resolved ) {
                return $resolved;
            }
        }

        if ( $item->url ) {
            $url = trim( $item->url );

            return match ( true ) {
                '#' === $url => '#',
                Str::startsWith( $url, '/' ) => $url,
                default => '/' . $url
            };
        }

        return '#';
    }
}
