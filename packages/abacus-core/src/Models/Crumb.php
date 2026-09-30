<?php
namespace Abacus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class Crumb extends Model {
    use HasTranslations, SoftDeletes;

    protected $table = 'crumbs';
    protected $guarded = [];

    protected $casts = [ 'redirect' => 'array' ];

    public array $translatable = [ 'crumb_title' ];

    public function crumbable() : MorphTo {
        return $this->morphTo();
    }
}
