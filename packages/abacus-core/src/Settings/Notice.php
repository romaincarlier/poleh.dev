<?php
namespace Abacus\Settings;

class Notice extends Settings {
    public string $type = 'information';
    public bool $is_active = false;
    public bool $is_shown_by_default = false;
    public array $title = [];
    public array $text = [];
    public array $content = [];
    public ?string $image = null;

    public static function group() : string {
        return 'notice';
    }

    public static function defaults() : array {
        return [
            'type' => 'information',
            'is_active' => false,
            'is_shown_by_default' => false,
            'title' => [],
            'text' => [],
            'content' => [],
            'image' => null
        ];
    }
}
