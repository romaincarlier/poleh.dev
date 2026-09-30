<?php
namespace Abacus\Filament\Actions;

use Filament\Actions\Action;

class Next extends Action {
    protected function setUp() : void {
        parent::setUp();

        $this->hiddenLabel()
            ->icon( 'heroicon-o-arrow-right' )
            ->outlined()
            ->tooltip( __( 'Next' ) );
    }

    public static function getDefaultName() : ?string {
        return 'next';
    }
}
