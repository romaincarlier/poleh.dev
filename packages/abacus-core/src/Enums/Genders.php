<?php
namespace Abacus\Enums;

use Filament\Support\Contracts\HasLabel;

enum Genders : string implements HasLabel {
    case MAN = 'man';
    case WOMAN = 'woman';
    case OTHER = 'other';

    public function getLabel() : string {
        return match ( $this ) {
            self::MAN => __( 'A man' ),
            self::WOMAN => __( 'A woman' ),
            self::OTHER => __( "I'd rather not say" )
        };
    }
}
