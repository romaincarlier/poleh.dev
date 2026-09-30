<?php
namespace Abacus\Concerns;

use Abacus\Models\Crumb;

use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string|null $title
 * @property string|null $name
 */
trait HasCrumbs {
    public function crumb() : MorphOne {
        return $this->morphOne( Crumb::class, 'crumbable' );
    }

    public function crumb_title() : string {
        return $this->crumb?->crumb_title ?: ( $this->title ?? $this->name ?? '' );
    }
}
