<?php

namespace App\Settings;

use App\Settings;

class Homepage extends Settings {
    public ?array $slides = [];
    public ?array $title = [];
    public ?array $content = [];
    public ?array $postlude = [];

    public static function group(): string {
        return 'homepage';
    }
}