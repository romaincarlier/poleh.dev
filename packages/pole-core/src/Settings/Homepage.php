<?php
namespace Modules\Pole\Core\Settings;

use Abacus\Settings\Settings;

class Homepage extends Settings {
    public array $slides = [];
    public array $title = [];
    public array $content = [];
    public array $postlude = [];

    public static function group() : string {
        return 'pole_core_homepage';
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
