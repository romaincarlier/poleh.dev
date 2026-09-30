<?php
namespace Abacus\Filament\Resources\Pages;

use Abacus\Filament\Resources\Concerns\CanNavigateRecords;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;

abstract class EditRecord extends BaseEditRecord {
    use CanNavigateRecords;

    protected function getHeaderActions() : array {
        return [
            Action::make( 'back' )
                ->label( __( 'Back to list' ) )
                ->icon( 'heroicon-o-arrow-left' )
                ->color( 'gray' )
                ->url( fn () => static::getResource()::getUrl( 'index' ) ),

            ...$this->navigation_actions(),

            DeleteAction::make()
        ];
    }
}
