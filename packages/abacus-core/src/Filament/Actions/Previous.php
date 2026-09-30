<?php
namespace Abacus\Filament\Actions;

use Filament\Actions\Action;

class Previous extends Action {
    protected function setUp() : void {
        parent::setUp();

        $this->hiddenLabel()
            ->icon( 'heroicon-o-arrow-left' )
            ->outlined()
            ->tooltip( __( 'Previous' ) );
    }

    public static function getDefaultName() : ?string {
        return 'previous';
    }
}
