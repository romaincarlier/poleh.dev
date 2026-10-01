<?php
namespace Modules\Pole\PTJS\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Modules\Pole\PTJS\Settings\Settings as PTJSSettings;

use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;

use BackedEnum;

class Options extends SettingsPage {
    protected static string $settings = PTJSSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 20;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    public static function getNavigationLabel() : string { return __( 'Plus tard je serai' ); }
    public function getTitle() : string { return __( 'Plus tard je serai' ); }
    public function getSubheading() : string { return __( 'Configure the "Plus tard je serai" section.' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            BaseForm::polyglot_input( 'title', __( 'Title' ) ),
            BaseForm::polyglot_editor( 'content', __( 'Content' ) ),
            TextInput::make( 'video_url' )->label( __( 'Youtube video URL' ) )->url()
        ] );
    }
}
