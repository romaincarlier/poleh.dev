<?php
namespace Modules\Pole\Help\Settings;

use Abacus\Settings\Settings as BaseSettings;

class Settings extends BaseSettings {
    public array $title = [];
    public array $introduction = [];
    public ?string $video_url = null;

    public static function group() : string {
        return 'pole_help_settings';
    }

    public static function defaults() : array {
        return [
            'title' => [],
            'introduction' => [],
            'video_url' => null
        ];
    }
}
