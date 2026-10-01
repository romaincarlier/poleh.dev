<?php
namespace Abacus\Enums;

use Filament\Support\Contracts\HasLabel;

enum Illustrations : string implements HasLabel {
    case Paramedical = 'paramedical';
    case Industry = 'industry';
    case Construction = 'construction';
    case InformationTechnology = 'information-technology';
    case Education = 'education';
    case Hospitality = 'hospitality';
    case Agriculture = 'agriculture';

    public function getLabel() : string {
        return match ( $this ) {
            self::Paramedical => __( 'Paramedical' ),
            self::Industry => __( 'Industry' ),
            self::Construction => __( 'Construction' ),
            self::InformationTechnology => __( 'Information technology' ),
            self::Education => __( 'Education' ),
            self::Hospitality => __( 'Hospitality' ),
            self::Agriculture => __( 'Agriculture' )
        };
    }

    // Placeholders, to be replaced with the real per-sector illustrations later.
    public function svg_path() : string {
        return 'images/illustrations/' . $this->value . '.svg';
    }
}
