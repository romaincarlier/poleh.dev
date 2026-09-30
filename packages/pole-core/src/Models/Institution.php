<?php
namespace Modules\Pole\Core\Models;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasSeo;
use Modules\Pole\Core\Models\Institution\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model {
    use HasComposedSlugs, HasCrumbs, HasSeo, SoftDeletes;

    protected $guarded = [];

    protected $casts = [ 'show_in_list' => 'boolean' ];

    public function category() : BelongsTo {
        return $this->belongsTo( Category::class, 'institution_category_id' );
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
