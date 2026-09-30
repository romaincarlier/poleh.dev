<?php
namespace Modules\PoleH\Core\Models\Event;

use Modules\PoleH\Core\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    protected $table = 'events_categories';
    protected $guarded = [];

    public function events() : BelongsToMany {
        return $this->belongsToMany( Event::class, 'events_events_categories', 'event_category_id', 'event_id' );
    }
}
