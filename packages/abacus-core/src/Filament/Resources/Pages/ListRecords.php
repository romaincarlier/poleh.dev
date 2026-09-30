<?php
namespace Abacus\Filament\Resources\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as BaseListRecords;

abstract class ListRecords extends BaseListRecords {
    protected function getHeaderActions() : array {
        return [
            CreateAction::make()
        ];
    }
}
