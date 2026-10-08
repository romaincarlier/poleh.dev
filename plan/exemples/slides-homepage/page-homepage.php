<?php

namespace App\Filament\Dashboard\Clusters\Settings\Pages;

use App\Filament\Common\Form;
use \App\Settings\Homepage as Settings;

use Filament\Schemas\Schema;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\{ TextInput, Repeater, Select};
use Filament\Schemas\Components\{ Tabs, Tabs\Tab, Group };

use BackedEnum;

class Homepage extends SettingsPage {
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static string $settings = Settings::class;

    // Textual context of the page resource
    public static function getNavigationGroup(): ?string { return __( 'Settings' ); }
    public function getSubheading(): ?string { return __( 'Configure the blocks that make up the homepage' ); }
    public static function getNavigationLabel(): string { return __( 'Homepage' ); }
    public function getTitle(): string { return __( 'Homepage' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Tabs::make()
                ->vertical()
                ->tabs( [
                    Tab::make( __( 'Slideshow' ) )
                        ->icon( 'heroicon-o-rectangle-stack' )
                        ->columns( 1 )
                        ->schema( [
                            Form::subheading( __( 'Slideshow content for the homepage' ) ),
                            Repeater::make( 'slides' )
                                ->hiddenLabel()
                                ->addActionLabel( __( 'Add a slide' ) )
                                ->collapsible()
                                ->itemLabel( fn ( array $state ) : ?string => $state[ 'title' ] ?? null )
                                ->live()
                                ->collapsed()
                                ->cloneable()
                                ->grid( 2 )
                                ->columns( 8 )
                                ->itemLabel( fn ( array $state ) : ?string => $state[ 'title' ] ?? null )
                                ->schema( [
                                    TextInput::make( 'title' )
                                        ->label( __( 'Title' ) )
                                        ->required()
                                        ->maxLength( 255 )
                                        ->columnSpan( 5 ),

                                    Select::make( 'type' )
                                        ->label( __( 'Type' ) )
                                        ->options( [
                                            'text' => __( 'Text' ),
                                            'image' => __( 'Image' )
                                        ] )
                                        ->default( 'text' )
                                        ->required()
                                        ->columnSpan( 3 )
                                        ->reactive(),

                                    Form::uploader( 'image' )
                                        ->label( __( 'Image' ) )
                                        ->directory( 'uploads/settings/slides' )
                                        ->required()
                                        ->columnSpanFull()
                                        ->visible( fn ( callable $get ) : bool => $get( 'type' ) === 'image' ),

                                    TextInput::make( 'subtitle' )
                                        ->label( __( 'Subtitle' ) )
                                        ->required()
                                        ->maxLength( 255 )
                                        ->columnSpan( 4 ),

                                    Form::uploader( 'background' )
                                        ->directory( 'slides' )
                                        ->label( __( 'Background' ) )
                                        ->columnSpan( 4 ),

                                    Form::link( 'outbound_link', __( 'Outbound link' ) )
                                        ->columnSpan( 8 )
                                        ->columns( 2 ),

                                    Form::editor( 'description', __( 'Description' ) )
                                        ->required()
                                        ->columnSpanFull()
                            ] )
                    ] )->columns( 1 ),
                    Tab::make( __( 'Content' ) )
                        ->icon( 'heroicon-o-home' )
                        ->columns( 1 )
                        ->schema( [
                            Form::subheading( __( 'Homepage' ) ),
                            Form::polyglot_input( 'title', __( 'Title' ) ),
                            Form::polyglot_editor( 'content', __( 'Content' ), __( 'Text for the (default) homepage content section, before "latest news".' ) ),
                            Form::polyglot_editor( 'postlude', __( 'Postlude' ), __( 'Used after the "upcoming events" section on the homepage.' ) ),
                        ] ),
                ] )->columns( 1 )
        ] )->columns( 1 );
    }
}
