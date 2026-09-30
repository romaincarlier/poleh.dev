<?php
namespace Abacus\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model {
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [ 'is_active' => 'boolean' ];

    public function positions() : BelongsToMany {
        return $this->belongsToMany( MenuPosition::class, 'menu_menu_position' )->withPivot( 'order' );
    }

    public function items() : HasMany {
        return $this->hasMany( Item::class )->whereNull( 'parent_id' )->orderBy( 'order' );
    }
}
