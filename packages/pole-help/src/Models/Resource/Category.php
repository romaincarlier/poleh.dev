<?php
namespace Modules\Pole\Help\Models\Resource;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasParents;
use Abacus\Enums\Illustrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use HasComposedSlugs, HasCrumbs, HasParents, SoftDeletes;

    protected $table = 'resources_categories';
    protected $guarded = [];

    protected $casts = [
        'illustration' => Illustrations::class,
        'resources' => 'array'
    ];

    public function children() : HasMany {
        return $this->hasMany( self::class, 'parent_id' )->orderBy( 'order' );
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
