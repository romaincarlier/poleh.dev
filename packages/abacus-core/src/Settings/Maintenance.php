<?php
namespace Abacus\Settings;

use Illuminate\Support\Carbon;

class Maintenance extends Settings {
    public bool $is_active = false;
    public array $title = [];
    public array $description = [];
    public ?Carbon $end_time = null;

    public static function group() : string {
        return 'maintenance';
    }

    public static function defaults() : array {
        return [
            'is_active' => false,
            'title' => [],
            'description' => [],
            'end_time' => null
        ];
    }
}
