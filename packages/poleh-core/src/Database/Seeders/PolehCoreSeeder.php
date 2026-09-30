<?php
namespace Modules\PoleH\Core\Database\Seeders;

use Abacus\Menu\Models\Menu;
use Abacus\Menu\Models\MenuPosition;

use Illuminate\Database\Seeder;

class PolehCoreSeeder extends Seeder {
    public function run() : void {
        foreach ( [
            [ 'name' => 'Prelude', 'slug' => 'prelude', 'order' => 1 ],
            [ 'name' => 'Header', 'slug' => 'header', 'order' => 2 ],
            [ 'name' => 'Footer', 'slug' => 'footer', 'order' => 3 ],
            [ 'name' => 'Legal', 'slug' => 'legal', 'order' => 4 ]
        ] as $data ) {
            $position = MenuPosition::updateOrCreate( [ 'slug' => $data[ 'slug' ] ], $data );

            $menu = Menu::firstOrCreate(
                [ 'slug' => $data[ 'slug' ] ],
                [ 'name' => $data[ 'name' ], 'is_active' => true ]
            );

            $position->menus()->syncWithoutDetaching( [ $menu->id => [ 'order' => 1 ] ] );
        }
    }
}
