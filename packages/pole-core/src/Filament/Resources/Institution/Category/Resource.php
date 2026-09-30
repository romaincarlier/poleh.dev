<?php
namespace Modules\Pole\Core\Filament\Resources\Institution\Category;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Core\Filament\Resources\Institution\Category\Pages\Manage;
use Modules\Pole\Core\Models\Institution\Category as CategoryModel;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = CategoryModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-library';
    protected static ?int $navigationSort = 11;

    public static function getNavigationLabel() : string { return __( 'Institution categories' ); }
    public static function getNavigationGroup() : string { return __( 'Institutions' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'plural_name' )->label( __( 'Plural name' ) )->helperText( __( 'Falls back to the name when left empty.' ) )->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            Select::make( 'parent_id' )
                ->label( __( 'Parent category' ) )
                ->options( fn ( $record ) => CategoryModel::query()
                    ->when( $record, fn ( $query ) => $query->where( 'id', '!=', $record->id ) )
                    ->pluck( 'name', 'id' ) )
                ->searchable(),

            BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

            BaseForm::editor( 'description', __( 'Description' ) )
        ] );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'parent' )->label( __( 'Parent' ) )->getStateUsing( fn ( CategoryModel $record ) => optional( $record->parent() )->name )->placeholder( '-' ),

            TextColumn::make( 'order' )->label( __( 'Order' ) )->sortable()
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Manage::route( '/' )
        ];
    }
}
