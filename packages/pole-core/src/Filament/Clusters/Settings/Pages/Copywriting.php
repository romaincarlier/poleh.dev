<?php
namespace Modules\Pole\Core\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Modules\Pole\Core\Settings\Copywriting as CopywritingSettings;

use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use BackedEnum;

class Copywriting extends SettingsPage {
    protected static string $settings = CopywritingSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 11;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-pencil-square';

    public static function getNavigationLabel() : string { return __( 'Copywriting' ); }
    public function getTitle() : string { return __( 'Copywriting' ); }
    public function getSubheading() : string { return __( 'Configure the text used on generic pages of the website.' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            Section::make( __( 'Error page' ) )
                ->description( __( 'Displayed when a visitor reaches a page that no longer exists.' ) )
                ->schema( [
                    BaseForm::polyglot_input( 'error_title', __( 'Title' ) ),
                    BaseForm::polyglot_editor( 'error_content', __( 'Content' ) ),
                    BaseForm::uploader( 'error_image' )->label( __( 'Header image' ) )->image()->directory( 'settings/copywriting' ),
                    BaseForm::uploader( 'error_image_mobile' )->label( __( 'Header image (mobile)' ) )->helperText( __( 'Falls back to the header image when left empty.' ) )->image()->directory( 'settings/copywriting' )
                ] )->columns( 2 ),

            Section::make( __( 'Content page' ) )
                ->schema( [
                    BaseForm::polyglot_input( 'content_title', __( 'Title' ) ),
                    BaseForm::polyglot_editor( 'content_content', __( 'Content' ) ),
                    BaseForm::uploader( 'content_image' )->label( __( 'Header image' ) )->image()->directory( 'settings/copywriting' ),
                    BaseForm::uploader( 'content_image_mobile' )->label( __( 'Header image (mobile)' ) )->helperText( __( 'Falls back to the header image when left empty.' ) )->image()->directory( 'settings/copywriting' )
                ] )->columns( 2 ),

            Section::make( __( 'Lexicon page' ) )
                ->description( __( 'Displayed at the top of the definitions/lexicon page.' ) )
                ->schema( [
                    BaseForm::polyglot_input( 'lexicon_title', __( 'Title' ) ),
                    BaseForm::polyglot_editor( 'lexicon_content', __( 'Content' ) )
                ] ),

            Section::make( __( 'Partners page' ) )
                ->description( __( 'Displayed at the top and bottom of the partners page.' ) )
                ->schema( [
                    BaseForm::polyglot_input( 'partner_title', __( 'Title' ) ),
                    BaseForm::polyglot_editor( 'partner_content', __( 'Content' ) ),
                    BaseForm::polyglot_input( 'partner_postlude_title', __( 'Postlude title' ) ),
                    BaseForm::polyglot_editor( 'partner_postlude_content', __( 'Postlude content' ) )
                ] )
        ] );
    }
}
