<?php
namespace Modules\PoleH\Core\Models;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasSeo;
use Modules\PoleH\Core\Models\Event\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {
    use HasComposedSlugs, HasCrumbs, HasSeo, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'datetime',
        'is_featured' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function categories() : BelongsToMany {
        return $this->belongsToMany( Category::class, 'events_events_categories', 'event_id', 'event_category_id' );
    }

    public function getDisplayLocationAttribute() : ?string {
        return $this->custom_location ?: $this->address_city;
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
