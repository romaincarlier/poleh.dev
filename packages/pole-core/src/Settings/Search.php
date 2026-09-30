<?php
namespace Modules\Pole\Core\Settings;

use Abacus\Settings\Settings;

class Search extends Settings {
    public array $predefined_terms = [];

    public static function group() : string {
        return 'pole_core_search';
    }

    public static function defaults() : array {
        return [
            'predefined_terms' => []
        ];
    }
}
