<?php
namespace Modules\Pole\Core\Filament\Resources\Post\Category\Pages;

use Modules\Pole\Core\Filament\Resources\Post\Category\Resource;

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
