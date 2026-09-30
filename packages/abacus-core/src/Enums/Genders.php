<?php
namespace Abacus\Enums;

use Filament\Support\Contracts\HasLabel;

enum Genders : string implements HasLabel {
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';
    case UNDISCLOSED = 'undisclosed';

    public function getLabel() : string {
        return match ( $this ) {
            self::MALE => __( 'Male' ),
            self::FEMALE => __( 'Female' ),
            self::OTHER => __( 'Other' ),
            self::UNDISCLOSED => __( 'Undisclosed' )
        };
    }
}
