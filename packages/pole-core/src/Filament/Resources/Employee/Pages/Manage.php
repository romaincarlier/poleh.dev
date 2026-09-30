<?php
namespace Modules\PoleH\Core\Filament\Resources\Employee\Pages;

use Modules\PoleH\Core\Filament\Resources\Employee\Resource;

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
