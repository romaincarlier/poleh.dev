<?php
namespace Modules\PoleH\Core\Settings;

use Abacus\Settings\Settings;

class Homepage extends Settings {
    public array $slides = [];
    public array $title = [];
    public array $content = [];
    public array $postlude = [];

    public static function group() : string {
        return 'poleh_core_homepage';
    }

    public static function defaults() : array {
        return [
            'slides' => [],
            'title' => [],
            'content' => [],
            'postlude' => []
        ];
    }
}
