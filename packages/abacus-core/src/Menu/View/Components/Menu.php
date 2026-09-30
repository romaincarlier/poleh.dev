<?php
namespace Abacus\Menu\View\Components;

use Abacus\Menu\Models\Item;
use Abacus\Menu\Models\MenuPosition;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Menu extends Component {
    public $items;

    public function __construct( public string $position ) {
        // Only the (safely serializable) ordered id list is cached - config('cache.serializable_classes')
        // defaults to false, so cached Eloquent models would come back as corrupt __PHP_Incomplete_Class
        // instances on the next request instead of throwing on write.
        $ids = Cache::remember(
            'abacus.menu.position.' . $position,
            now()->addHour(),
            fn () => MenuPosition::where( 'slug', $position )->first()
                ?->menus()->where( 'is_active', true )->first()
                ?->items()->pluck( 'id' )->all()
                ?? []
        );

        $by_id = Item::whereIn( 'id', $ids )->with( 'children' )->get()->keyBy( 'id' );

        $this->items = collect( $ids )->map( fn ( $id ) => $by_id->get( $id ) )->filter()->values();
    }

    public function render() {
        return view( 'abacus::components.menu' );
    }
}
