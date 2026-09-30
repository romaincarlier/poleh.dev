<?php
namespace Abacus\Enums\Notice;

use Filament\Support\Contracts\HasLabel;

enum Types : string implements HasLabel {
    case WARNING = 'warning';
    case INFORMATION = 'information';
    case SUCCESS = 'success';
    case ERROR = 'error';
    case ACCENT = 'accent';

    public function getLabel() : string {
        return match ( $this ) {
            self::WARNING => __( 'Warning' ),
            self::INFORMATION => __( 'Information' ),
            self::SUCCESS => __( 'Success' ),
            self::ERROR => __( 'Error' ),
            self::ACCENT => __( 'Accent' )
        };
    }
}
