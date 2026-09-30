<?php
namespace Abacus\Settings;

class Email extends Settings {
    public bool $is_sending_disabled = false;
    public array $disabled_notice = [];

    public static function group() : string {
        return 'email';
    }

    public static function defaults() : array {
        return [
            'is_sending_disabled' => false,
            'disabled_notice' => []
        ];
    }
}
