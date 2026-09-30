<?php
namespace Abacus\Concerns;

/**
 * @property string|null $breadcrumb_title
 * @property string|null $title
 * @property string|null $name
 */
trait HasCrumbs {
    public function crumb_title() : string {
        return $this->breadcrumb_title ?: ( $this->title ?? $this->name ?? '' );
    }
}
