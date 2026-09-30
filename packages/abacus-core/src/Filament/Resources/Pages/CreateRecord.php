<?php
namespace Abacus\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord as BaseCreateRecord;

abstract class CreateRecord extends BaseCreateRecord {
    protected function getHeaderActions() : array {
        return [
            Action::make( 'back' )
                ->label( __( 'Back to list' ) )
                ->icon( 'heroicon-o-arrow-left' )
                ->color( 'gray' )
                ->url( fn () => static::getResource()::getUrl( 'index' ) )
        ];
    }
}
