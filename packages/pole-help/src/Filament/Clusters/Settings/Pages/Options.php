<?php
namespace Modules\Pole\Help\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Modules\Pole\Help\Settings\Settings as HelpSettings;

use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;

use BackedEnum;

class Options extends SettingsPage {
    protected static string $settings = HelpSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 21;
    protected static ?string $slug = 'help-options';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-heart';

    public static function getNavigationLabel() : string { return __( 'Aide & Precarite' ); }
    public function getTitle() : string { return __( 'Aide & Precarite' ); }
    public function getSubheading() : string { return __( 'Configure the "Aide & Precarite" section.' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            BaseForm::polyglot_input( 'title', __( 'Title' ) ),
            BaseForm::polyglot_editor( 'introduction', __( 'Introduction' ) ),
            TextInput::make( 'video_url' )->label( __( 'Youtube video URL' ) )->url()
        ] );
    }
}
