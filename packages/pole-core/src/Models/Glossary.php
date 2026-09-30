<?php
namespace Modules\Pole\Core\Models;

use Abacus\Concerns\HasComposedSlugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class Glossary extends Model {
    use HasComposedSlugs, HasTranslations, SoftDeletes;

    protected $guarded = [];

    public array $translatable = [ 'name', 'description', 'slug' ];

    public function questions() : HasMany {
        return $this->hasMany( Question::class )->orderBy( 'order' );
    }

    public function getRouteKeyName() : string {
        return 'slug';
    }
}
