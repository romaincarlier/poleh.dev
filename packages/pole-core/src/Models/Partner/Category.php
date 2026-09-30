<?php
namespace Modules\Pole\Core\Models\Partner;

use Modules\Pole\Core\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    protected $table = 'partners_categories';
    protected $guarded = [];

    public function partners() : HasMany {
        return $this->hasMany( Partner::class, 'partner_category_id' );
    }
}
