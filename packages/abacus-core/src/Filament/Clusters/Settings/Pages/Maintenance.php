<?php
namespace Abacus\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Abacus\Settings\Maintenance as MaintenanceSettings;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Illuminate\Support\Facades\Log;

use BackedEnum;

class Maintenance extends SettingsPage {
    protected static string $settings = MaintenanceSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 6;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public function getHeading() : string { return __( 'Maintenance mode' ); }
    public function getSubheading() : string { return __( 'Set, remove, configure the maintenance mode for the website.' ); }
    public static function getNavigationLabel() : string { return __( 'Maintenance mode' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Section::make( __( 'Maintenance mode' ) )
                ->description( __( 'Disable all public access to the website for a period.' ) )
                ->schema( [
                    Toggle::make( 'is_active' )
                        ->label( __( 'Enable maintenance mode' ) )
                        ->default( false )
                        ->afterStateUpdated( fn ( $state ) => Log::info( $state ? 'Maintenance mode activated' : 'Maintenance mode deactivated', [
                            'user_id' => auth()->id()
                        ] ) ),

                    BaseForm::polyglot_input( 'title', __( 'Title' ) ),

                    BaseForm::polyglot_editor( 'description', __( 'Description' ) ),

                    DateTimePicker::make( 'end_time' )
                        ->label( __( 'Indicative end time' ) )
                        ->helperText( __( 'Optional - displayed on the maintenance page if set and in the future.' ) )
                        ->seconds( false )
                ] )
        ] );
    }
}
