<?php
namespace Modules\Pole\Core\Models;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasMedia;
use Abacus\Concerns\HasSeo;
use Modules\Pole\Core\Models\Post\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Post extends Model {
    use HasComposedSlugs, HasCrumbs, HasMedia, HasSeo, SoftDeletes;

    protected $guarded = [];

    protected $casts = [ 'is_published' => 'boolean' ];

    public function author() : BelongsTo {
        return $this->belongsTo( User::class, 'author_id' );
    }

    public function categories() : BelongsToMany {
        return $this->belongsToMany( Category::class, 'posts_posts_categories', 'post_id', 'post_category_id' );
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
