<?php
namespace Abacus\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Settings\General as GeneralSettings;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use BackedEnum;

class General extends SettingsPage {
    protected static string $settings = GeneralSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 1;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';

    public function getHeading() : string { return __( 'General' ); }
    public function getSubheading() : string { return __( 'Site-wide defaults used as the last fallback tier for SEO metadata.' ); }
    public static function getNavigationLabel() : string { return __( 'General' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Section::make( __( 'Site identity' ) )->schema( [
                TextInput::make( 'site_name' )->label( __( 'Site name' ) )->required()->maxLength( 255 ),

                TextInput::make( 'contact_email' )->label( __( 'Contact email' ) )->email()->maxLength( 255 )
            ] )->columns( 2 ),

            Section::make( __( 'Default SEO metadata' ) )
                ->description( __( 'Used when a page has no more specific SEO metadata set.' ) )
                ->schema( [
                    TextInput::make( 'default_meta_title' )->label( __( 'Default meta title' ) )->maxLength( 255 ),

                    TextInput::make( 'default_meta_description' )->label( __( 'Default meta description' ) )->maxLength( 255 ),

                    FileUpload::make( 'default_meta_image' )->label( __( 'Default meta image' ) )->image()->disk( 'public' )->directory( 'settings' ),

                    TextInput::make( 'twitter_handle' )->label( __( 'Twitter handle' ) )->maxLength( 255 )
                ] )->columns( 2 )
        ] );
    }
}
