<?php
namespace Abacus\Filament\Clusters\Settings\Pages;

use Abacus\Enums\Notice\Types;
use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Abacus\Settings\Notice as NoticeSettings;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use BackedEnum;

class Notice extends SettingsPage {
    protected static string $settings = NoticeSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 5;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-speaker-wave';

    public function getHeading() : string { return __( 'General notice' ); }
    public function getSubheading() : string { return __( 'Configure the general notice modal displayed to visitors.' ); }
    public static function getNavigationLabel() : string { return __( 'General notice' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Section::make( __( 'Notice configuration' ) )
                ->description( __( 'Displayed on every page and can be opened.' ) )
                ->schema( [
                    Group::make()->columnSpan( 2 )->schema( [
                        BaseForm::polyglot_input( 'title', __( 'Title' ) ),

                        BaseForm::polyglot_editor( 'text', __( 'Text' ) ),

                        BaseForm::polyglot_editor( 'content', __( 'Content' ) )
                    ] ),

                    Group::make()->schema( [
                        Select::make( 'type' )->label( __( 'Type' ) )->options( Types::class )->required(),

                        FileUpload::make( 'image' )
                            ->label( __( 'Illustration' ) )
                            ->image()
                            ->disk( 'public' )
                            ->directory( 'settings' ),

                        Toggle::make( 'is_active' )->label( __( 'Display the notice' ) )->default( false ),

                        Toggle::make( 'is_shown_by_default' )->label( __( 'Automatically open when visitors arrive on the site' ) )->default( false )
                    ] )
                ] )->columns( 3 )
        ] );
    }
}
