<?php
namespace Modules\Pole\Core\Models\Post;

use Modules\Pole\Core\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    protected $table = 'posts_categories';
    protected $guarded = [];

    public function posts() : BelongsToMany {
        return $this->belongsToMany( Post::class, 'posts_posts_categories', 'post_category_id', 'post_id' );
    }
}
