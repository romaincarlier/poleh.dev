<?php
namespace Abacus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class SEO extends Model {
    use HasTranslations, SoftDeletes;

    protected $table = 'seo';
    protected $guarded = [];

    public array $translatable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'opengraph_title',
        'opengraph_description'
    ];

    public function seoable() : MorphTo {
        return $this->morphTo();
    }
}
