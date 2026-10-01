<?php
namespace Modules\Pole\Help\Filament\Resources\Category;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Help\Filament\Resources\Category\Pages\Create;
use Modules\Pole\Help\Filament\Resources\Category\Pages\Edit;
use Modules\Pole\Help\Filament\Resources\Category\Pages\Index;
use Modules\Pole\Help\Models\Resource\Category as CategoryModel;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = CategoryModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-heart';
    protected static ?int $navigationSort = 80;

    public static function getNavigationLabel() : string { return __( 'Resources' ); }
    public static function getNavigationGroup() : string { return __( 'Aide & Precarite' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            Group::make()->columnSpan( [ 'lg' => 3 ] )->schema( [
                Section::make( __( 'Content' ) )->schema( [
                    TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

                    TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

                    BaseForm::illustration( 'illustration' ),

                    Select::make( 'parent_id' )
                        ->label( __( 'Parent category' ) )
                        ->options( fn ( $record ) => CategoryModel::query()
                            ->when( $record, fn ( $query ) => $query->where( 'id', '!=', $record->id ) )
                            ->pluck( 'name', 'id' ) )
                        ->searchable(),

                    TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

                    BaseForm::uploader( 'background_image' )->label( __( 'Background image' ) )->image()->directory( 'help/categories' ),

                    BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

                    BaseForm::editor( 'description', __( 'Description' ) )
                ] )->columns( 2 ),

                Section::make( __( 'Resources' ) )->schema( [
                    Repeater::make( 'resources' )
                        ->hiddenLabel()
                        ->addActionLabel( __( 'Add a resource' ) )
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel( fn ( array $state ) : ?string => $state[ 'title' ] ?? null )
                        ->schema( [
                            TextInput::make( 'title' )->label( __( 'Title' ) )->required()->maxLength( 255 ),

                            TextInput::make( 'url' )->label( __( 'URL' ) )->url()->maxLength( 255 ),

                            TextInput::make( 'description' )->label( __( 'Description' ) )->maxLength( 255 )
                        ] )->columns( 3 )
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

            TextColumn::make( 'parent' )->label( __( 'Parent' ) )->getStateUsing( fn ( CategoryModel $record ) => optional( $record->parent() )->name )->placeholder( '-' )
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
