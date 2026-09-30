<?php
namespace Abacus\Settings;

class General extends Settings {
    public string $site_name;
    public ?string $default_meta_title = null;
    public ?string $default_meta_description = null;
    public ?string $default_meta_image = null;
    public ?string $twitter_handle = null;
    public ?string $contact_email = null;

    public static function group() : string {
        return 'general';
    }

    public static function defaults() : array {
        return [
            'site_name' => config( 'app.name' ),
            'default_meta_title' => null,
            'default_meta_description' => null,
            'default_meta_image' => null,
            'twitter_handle' => null,
            'contact_email' => null
        ];
    }
}
