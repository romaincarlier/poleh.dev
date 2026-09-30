<?php
namespace Modules\Pole\Core\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Modules\Pole\Core\Settings\Homepage as HomepageSettings;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

use BackedEnum;

class Homepage extends SettingsPage {
    protected static string $settings = HomepageSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 10;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    public static function getNavigationLabel() : string { return __( 'Homepage' ); }
    public function getSubheading() : string { return __( 'Configure the blocks that make up the homepage.' ); }
    public function getTitle() : string { return __( 'Homepage' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Tabs::make()->vertical()->tabs( [
                Tab::make( __( 'Slideshow' ) )
                    ->icon( 'heroicon-o-rectangle-stack' )
                    ->schema( [
                        Repeater::make( 'slides' )
                            ->hiddenLabel()
                            ->addActionLabel( __( 'Add a slide' ) )
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->grid( 2 )
                            ->itemLabel( fn ( array $state ) : ?string => $state[ 'title' ] ?? null )
                            ->schema( [
                                TextInput::make( 'title' )->label( __( 'Title' ) )->required()->maxLength( 255 )->columnSpanFull(),

                                TextInput::make( 'subtitle' )->label( __( 'Subtitle' ) )->maxLength( 255 )->columnSpanFull(),

                                BaseForm::uploader( 'image' )->label( __( 'Image' ) )->image()->directory( 'settings/slides' )->required()->columnSpanFull(),

                                BaseForm::uploader( 'mobile_image' )
                                    ->label( __( 'Mobile image' ) )
                                    ->helperText( __( 'Falls back to the main image when left empty.' ) )
                                    ->image()
                                    ->directory( 'settings/slides' )
                                    ->columnSpanFull(),

                                BaseForm::link( 'outbound_link', __( 'Outbound link' ) )->columnSpanFull(),

                                BaseForm::editor( 'description', __( 'Description' ) )->columnSpanFull()
                            ] )
                    ] ),

                Tab::make( __( 'Content' ) )
                    ->icon( 'heroicon-o-document-text' )
                    ->schema( [
                        BaseForm::polyglot_input( 'title', __( 'Title' ) ),

                        BaseForm::polyglot_editor( 'content', __( 'Content' ), __( 'Text for the homepage content section, before "latest news".' ) ),

                        BaseForm::polyglot_editor( 'postlude', __( 'Postlude' ), __( 'Used after the "upcoming events" section on the homepage.' ) )
                    ] )
            ] )
        ] );
    }
}
