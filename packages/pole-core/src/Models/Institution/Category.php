<?php
namespace Modules\Pole\Core\Models\Institution;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasParents;
use Modules\Pole\Core\Models\Institution;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use HasComposedSlugs, HasCrumbs, HasParents, SoftDeletes;

    protected $table = 'institutions_categories';
    protected $guarded = [];

    public function children() : HasMany {
        return $this->hasMany( self::class, 'parent_id' )->orderBy( 'order' );
    }

    public function institutions() : HasMany {
        return $this->hasMany( Institution::class, 'institution_category_id' );
    }

    public function getPluralNameAttribute() : string {
        return $this->attributes[ 'plural_name' ] ?: $this->name;
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
