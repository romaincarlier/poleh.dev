<?php
namespace Modules\Pole\Core\Settings;

use Abacus\Settings\Settings;

class Copywriting extends Settings {
    public array $error_title = [];
    public array $error_content = [];
    public ?string $error_image = null;
    public ?string $error_image_mobile = null;

    public array $content_title = [];
    public array $content_content = [];
    public ?string $content_image = null;
    public ?string $content_image_mobile = null;

    public array $lexicon_title = [];
    public array $lexicon_content = [];

    public static function group() : string {
        return 'pole_core_copywriting';
    }

    public static function defaults() : array {
        return [
            'error_title' => [],
            'error_content' => [],
            'error_image' => null,
            'error_image_mobile' => null,
            'content_title' => [],
            'content_content' => [],
            'content_image' => null,
            'content_image_mobile' => null,
            'lexicon_title' => [],
            'lexicon_content' => []
        ];
    }
}
