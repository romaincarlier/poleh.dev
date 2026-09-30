<?php
namespace Abacus\Menu\View\Components;

use Abacus\Menu\Models\MenuPosition;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Menu extends Component {
    public $items;

    public function __construct( public string $position ) {
        $this->items = Cache::remember(
            'abacus.menu.position.' . $position,
            now()->addHour(),
            fn () => MenuPosition::where( 'slug', $position )->first()
                ?->menus()->where( 'is_active', true )->first()
                ?->items()->with( 'children' )->get()
                ?? collect()
        );
    }

    public function render() {
        return view( 'abacus::components.menu' );
    }
}
