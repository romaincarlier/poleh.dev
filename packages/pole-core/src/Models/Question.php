<?php
namespace Modules\Pole\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Translatable\HasTranslations;

class Question extends Model {
    use HasTranslations, SoftDeletes;

    protected $guarded = [];

    public array $translatable = [ 'question', 'answer' ];

    public function glossary() : BelongsTo {
        return $this->belongsTo( Glossary::class );
    }
}
