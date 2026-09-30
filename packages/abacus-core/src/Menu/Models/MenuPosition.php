<?php
namespace Abacus\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuPosition extends Model {
    use SoftDeletes;

    protected $guarded = [];

    public function menus() : BelongsToMany {
        return $this->belongsToMany( Menu::class, 'menu_menu_position' )->withPivot( 'order' )->orderByPivot( 'order' );
    }
}
