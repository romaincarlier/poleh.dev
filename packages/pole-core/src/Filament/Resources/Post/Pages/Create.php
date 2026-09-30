<?php
namespace Modules\Pole\Core\Filament\Resources\Post\Pages;

use Abacus\Filament\Resources\Pages\CreateRecord;
use Modules\Pole\Core\Filament\Resources\Post\Resource;

class Create extends CreateRecord {
    protected static string $resource = Resource::class;
}
