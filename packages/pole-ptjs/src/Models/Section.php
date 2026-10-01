<?php
namespace Modules\Pole\PTJS\Models;

use Abacus\Concerns\HasComposedSlugs;
use Abacus\Concerns\HasCrumbs;
use Abacus\Enums\Illustrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model {
    use HasComposedSlugs, HasCrumbs, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'illustration' => Illustrations::class,
        'jobs' => 'array',
        'speakers' => 'array',
        'chapters' => 'array'
    ];

    public function getRouteKeyName() : string {
        return 'slug';
    }

    public function getYoutubeIdAttribute() : ?string {
        if ( ! $this->video_url ) {
            return null;
        }

        preg_match( '/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&?\/]+)/', $this->video_url, $matches );

        return $matches[ 1 ] ?? null;
    }
}
