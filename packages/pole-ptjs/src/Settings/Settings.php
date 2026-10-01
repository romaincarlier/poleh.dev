<?php
namespace Modules\Pole\PTJS\Settings;

use Abacus\Settings\Settings as BaseSettings;

class Settings extends BaseSettings {
    public array $title = [];
    public array $content = [];
    public ?string $video_url = null;

    public static function group() : string {
        return 'pole_ptjs_settings';
    }

    public static function defaults() : array {
        return [
            'title' => [],
            'content' => [],
            'video_url' => null
        ];
    }
}
