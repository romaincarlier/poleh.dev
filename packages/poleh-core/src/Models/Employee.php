<?php
namespace Modules\PoleH\Core\Models;

use Abacus\Concerns\HasComposedSlugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class Employee extends Model {
    use HasComposedSlugs, HasTranslations, SoftDeletes;

    protected $guarded = [];

    public array $translatable = [ 'description' ];

    public function getRouteKeyName() : string {
        return 'slug';
    }

    public function getFullNameAttribute() : string {
        return trim( $this->first_name . ' ' . $this->name );
    }
}
