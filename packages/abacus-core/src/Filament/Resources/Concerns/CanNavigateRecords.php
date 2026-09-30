<?php
namespace Abacus\Filament\Resources\Concerns;

use Abacus\Filament\Actions\Next;
use Abacus\Filament\Actions\Previous;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Filament\Resources\Pages\EditRecord
 */
trait CanNavigateRecords {
    protected function previous_record() : ?Model {
        return $this->getRecord()->newQuery()
            ->where( 'id', '<', $this->getRecord()->id )
            ->orderBy( 'id', 'desc' )
            ->first();
    }

    protected function next_record() : ?Model {
        return $this->getRecord()->newQuery()
            ->where( 'id', '>', $this->getRecord()->id )
            ->orderBy( 'id', 'asc' )
            ->first();
    }

    protected function navigation_actions() : array {
        return [
            Previous::make()
                ->url( fn () => ( $record = $this->previous_record() )
                    ? static::getResource()::getUrl( static::getResourcePageName(), [ 'record' => $record ] )
                    : null )
                ->disabled( fn () => ! $this->previous_record() ),

            Next::make()
                ->url( fn () => ( $record = $this->next_record() )
                    ? static::getResource()::getUrl( static::getResourcePageName(), [ 'record' => $record ] )
                    : null )
                ->disabled( fn () => ! $this->next_record() )
        ];
    }
}
