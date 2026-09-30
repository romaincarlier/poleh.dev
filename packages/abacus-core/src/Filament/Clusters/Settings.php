<?php
namespace Abacus\Filament\Clusters;

use Filament\Clusters\Cluster;

use BackedEnum;

class Settings extends Cluster {
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel() : string { return __( 'Website settings' ); }
    public static function getNavigationGroup() : string { return __( 'Settings' ); }
}
