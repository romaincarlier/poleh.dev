<?php
namespace Modules\PoleH\Core\Filament\Resources\Event\Pages;

use Abacus\Filament\Resources\Pages\CreateRecord;
use Modules\PoleH\Core\Filament\Resources\Event\Resource;

class Create extends CreateRecord {
    protected static string $resource = Resource::class;
}
