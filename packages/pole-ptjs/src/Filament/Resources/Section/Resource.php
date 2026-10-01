<?php
namespace Modules\Pole\PTJS\Filament\Resources\Section;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\PTJS\Filament\Resources\Section\Pages\Create;
use Modules\Pole\PTJS\Filament\Resources\Section\Pages\Edit;
use Modules\Pole\PTJS\Filament\Resources\Section\Pages\Index;
use Modules\Pole\PTJS\Models\Section as SectionModel;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section as FormSection;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = SectionModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 70;

    public static function getNavigationLabel() : string { return __( 'Sections' ); }
    public static function getNavigationGroup() : string { return __( 'Plus tard je serai' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            Group::make()->columnSpan( [ 'lg' => 3 ] )->schema( [
                FormSection::make( __( 'Content' ) )->schema( [
                    TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

                    TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

                    BaseForm::illustration( 'illustration' ),

                    TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

                    TextInput::make( 'video_url' )
                        ->label( __( 'Youtube video URL' ) )
                        ->url()
                        ->rule( 'regex:/^https?:\/\/(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)/' )
                        ->validationMessages( [ 'regex' => __( 'This does not look like a Youtube video URL.' ) ] ),

                    BaseForm::uploader( 'background_image' )->label( __( 'Background image' ) )->image()->directory( 'ptjs/sections' ),

                    BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

                    BaseForm::editor( 'description', __( 'Description' ) )
                ] )->columns( 2 ),

                FormSection::make( __( 'Jobs & speakers' ) )->schema( [
                    TagsInput::make( 'jobs' )->label( __( 'Jobs' ) ),

                    TagsInput::make( 'speakers' )->label( __( 'Speakers' ) )
                ] )->columns( 2 ),

                FormSection::make( __( 'Chapters' ) )->schema( [
                    Repeater::make( 'chapters' )
                        ->hiddenLabel()
                        ->addActionLabel( __( 'Add a chapter' ) )
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel( fn ( array $state ) : ?string => data_get( $state, 'title.' . array_key_first( config( 'abacus.locales' ) ) ) )
                        ->schema( [
                            Tabs::make()->columnSpanFull()->tabs(
                                collect( config( 'abacus.locales' ) )->map( fn ( $label, $locale ) => Tab::make( $label )->schema( [
                                    TextInput::make( 'title.' . $locale )->label( __( 'Title' ) )->maxLength( 255 )
                                ] ) )->values()->all()
                            ),

                            Textarea::make( 'description' )->label( __( 'Description' ) )->columnSpanFull(),

                            TextInput::make( 'timestamp' )->label( __( 'Timestamp' ) )->numeric()->suffix( __( 'seconds' ) )->required()
                        ] )
                ] )
            ] ),

            Group::make()->columnSpan( [ 'lg' => 1 ] )->schema( [
                BaseForm::breadcrumbs()
            ] )
        ] )->columns( 4 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            ImageColumn::make( 'background_image' )->label( __( 'Image' ) )->disk( 'public' ),

            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'illustration' )->label( __( 'Illustration' ) )->badge()
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }
}
