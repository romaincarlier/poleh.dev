<?php
namespace Abacus\Filament\Resources\MenuPosition\Pages;

use Abacus\Filament\Resources\MenuPosition\Resource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class Manage extends ManageRecords {
    protected static string $resource = Resource::class;

    protected function getHeaderActions() : array {
        return [
            CreateAction::make()
        ];
    }
}
