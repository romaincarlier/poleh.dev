<?php
namespace Modules\Pole\Core\Models;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Concerns\HasMedia;
use Abacus\Concerns\HasSeo;
use Modules\Pole\Core\Models\Post\Category;
use Modules\Pole\Core\Models\Post\Tag;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use Carbon\Carbon;

class Post extends Model {
    use HasComposedSlugs, HasCrumbs, HasMedia, HasSeo, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function author() : BelongsTo {
        return $this->belongsTo( User::class, 'author_id' );
    }

    public function categories() : BelongsToMany {
        return $this->belongsToMany( Category::class, 'posts_posts_categories', 'post_id', 'post_category_id' );
    }

    public function tags() : BelongsToMany {
        return $this->belongsToMany( Tag::class, 'posts_posts_tags', 'post_id', 'post_tag_id' );
    }

    public function getPublicationDateAttribute() : Carbon {
        return $this->published_at ?? $this->created_at;
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
