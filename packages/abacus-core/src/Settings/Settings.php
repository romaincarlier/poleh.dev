<?php
namespace Abacus\Settings;

use Spatie\LaravelSettings\Settings as SpatieSettings;

abstract class Settings extends SpatieSettings {
    // Every settings class declares its own defaults here instead of a migration -
    // `abacus:settings` inserts whatever is missing.
    abstract public static function defaults() : array;
}
