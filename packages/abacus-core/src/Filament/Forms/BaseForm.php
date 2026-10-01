<?php
namespace Abacus\Filament\Forms;

use Abacus\Enums\Illustrations;
use Abacus\Filament\Blocks\Block;
use Abacus\Filament\Components\Address;
use Abacus\Filament\Components\Polyglot;
use Abacus\Support\Discovery;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;

use RalphJSmit\Filament\Upload\Filament\Forms\Components\AdvancedFileUpload;

class BaseForm {
    public static function format( bool $simple = true ) : array {
        $toolbar = $simple
            ? [ 'bold', 'italic', 'strike', 'underline', 'link', 'undo', 'redo', 'customBlocks' ]
            : [ 'bold', 'italic', 'strike', 'underline', 'blockquote', 'bulletList', 'orderedList', 'h2', 'h3', 'h4', 'link', 'undo', 'redo', 'customBlocks' ];

        return $toolbar;
    }

    public static function editor( string $name, string | false | null $label = null ) : RichEditor {
        $editor = RichEditor::make( $name )
            ->toolbarButtons( self::format() )
            ->customBlocks( Discovery::classes_in( config( 'abacus.block_paths' ), Block::class ) )
            ->extraInputAttributes( [ 'style' => 'min-height: 15rem;' ] );

        return ( empty( $label ) ) ? $editor->hiddenLabel() : $editor->label( $label );
    }

    public static function polyglot_input( string $name, string $label, ?string $helper_text = null ) : Polyglot {
        $field = Polyglot::make( $name )
            ->receiver( TextInput::make( $name ) )
            ->label( $label );

        return $helper_text ? $field->helperText( $helper_text ) : $field;
    }

    public static function polyglot_editor( string $name, string $label, ?string $helper_text = null ) : Polyglot {
        $field = Polyglot::make( $name )
            ->receiver( RichEditor::make( $name )->toolbarButtons( self::format() )->customBlocks( Discovery::classes_in( config( 'abacus.block_paths' ), Block::class ) ) )
            ->label( $label );

        return $helper_text ? $field->helperText( $helper_text ) : $field;
    }

    public static function polyglot_tags( string $name, string $label, ?string $helper_text = null ) : Polyglot {
        $field = Polyglot::make( $name )
            ->receiver( TagsInput::make( $name ) )
            ->label( $label );

        return $helper_text ? $field->helperText( $helper_text ) : $field;
    }

    public static function subheading( string $title ) : Component {
        return Text::make( $title )
            ->size( 'lg' )
            ->weight( 'bold' )
            ->columnSpanFull();
    }

    public static function uploader( string $name ) : AdvancedFileUpload {
        return AdvancedFileUpload::make( $name )
            ->disk( 'public' )
            ->directory( 'uploads' )
            ->uploadingMessage( __( 'Please wait while the file(s) are being uploaded...' ) )
            ->dropzoneHeading( null )
            ->dropzoneDescription( null )
            ->dropzonePreviewLeftIcon( null )
            ->dropzonePreviewCenterIcon( null )
            ->dropzonePreviewRightIcon( null )
            ->dropzoneAfterFiles()
            ->addAction( function ( Action $action, AdvancedFileUpload $component ) {
                $is_pdf = in_array( 'application/pdf', $component->getAcceptedFileTypes()->toArray() );

                return $action->label( match ( true ) {
                    $is_pdf && $component->isMultiple() => __( 'Select or drop PDF files' ),
                    $is_pdf => __( 'Select or drop a PDF file' ),
                    $component->isMultiple() => __( 'Select or drop images' ),
                    default => __( 'Select or drop an image' )
                } );
            } );
    }

    public static function link( string $name, string $label, int $columns = 1 ) : Component {
        return Fieldset::make( $label )->statePath( $name )->schema( [
            TextInput::make( 'title' )->label( __( 'Title' ) )->maxLength( 255 ),
            TextInput::make( 'label' )->label( __( 'Label' ) )->maxLength( 255 ),
            TextInput::make( 'destination' )->label( __( 'Destination' ) )->maxLength( 255 ),
            TextInput::make( 'class' )->label( __( 'Class' ) )->maxLength( 255 )
        ] )->columns( 2 )->columnSpan( $columns );
    }

    // Backed by the shared polymorphic Abacus\Models\SEO model (morphOne 'seo' relationship) -
    // use on a model with the HasSeo concern.
    public static function seo() : Component {
        return Section::make( __( 'SEO' ) )->relationship( 'seo' )->description( __( 'Search Engine Optimization (SEO)' ) )->schema( [
            Fieldset::make( __( 'Metadata' ) )->schema( [
                self::polyglot_input( 'meta_title', __( 'Meta title' ) ),
                self::polyglot_input( 'meta_description', __( 'Meta description' ) ),
                self::polyglot_input( 'meta_keywords', __( 'Meta keywords' ) ),
                self::polyglot_input( 'meta_robots', __( 'Meta robots' ) )
            ] ),

            Fieldset::make( __( 'Opengraph' ) )->schema( [
                self::polyglot_input( 'opengraph_title', __( 'Opengraph title' ) ),
                self::polyglot_input( 'opengraph_description', __( 'Opengraph description' ) ),
                FileUpload::make( 'opengraph_image' )->label( __( 'Opengraph image' ) )->image()->directory( 'media' )
            ] )
        ] );
    }

    // Backed by the shared polymorphic Abacus\Models\Crumb model (morphOne 'crumb' relationship) -
    // use on a model with the HasCrumbs concern.
    public static function breadcrumbs() : Component {
        return Section::make( __( 'Breadcrumb' ) )->relationship( 'crumb' )->schema( [
            self::polyglot_input( 'crumb_title', __( 'Breadcrumb title' ) ),
            self::link( 'redirect', __( 'Redirect' ) )
        ] )->columnSpan( [ 'lg' => 1 ] );
    }

    public static function address( string $name ) : Component {
        return Address::make( $name );
    }

    // Shared between every module that needs a per-section/category illustration picker -
    // renders a small SVG preview to the left of each option's name.
    public static function illustration( string $name ) : Select {
        return Select::make( $name )
            ->label( __( 'Illustration' ) )
            ->options( collect( Illustrations::cases() )->mapWithKeys( fn ( Illustrations $case ) => [
                $case->value => '<img src="' . asset( $case->svg_path() ) . '" style="height: 1.25rem; width: 1.25rem; display: inline-block; vertical-align: middle; margin-right: .5rem;" alt=""> ' . $case->getLabel()
            ] ) )
            ->allowHtml()
            ->native( false )
            ->searchable();
    }

    public static function unit( float | int $value, string $unit = '€', ?int $precision = null ) : string {
        if ( is_int( $precision ) ) {
            $value = round( $value, $precision );
        }

        return '<span class="fi-badge">' . $value . ' ' . $unit . '</span>';
    }

    public static function colored( $related_model ) : string {
        return '<span class="fi-badge">' . $related_model->name . '</span>';
    }
}
