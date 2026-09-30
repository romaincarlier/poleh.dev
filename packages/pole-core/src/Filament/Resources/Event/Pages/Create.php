<?php
namespace Modules\Pole\Core\Filament\Resources\Event\Pages;

use Abacus\Filament\Resources\Pages\CreateRecord;
use Modules\Pole\Core\Filament\Resources\Event\Resource;

class Create extends CreateRecord {
    protected static string $resource = Resource::class;
}
