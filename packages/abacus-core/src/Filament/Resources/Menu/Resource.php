<?php
namespace Abacus\Filament\Resources\Menu;

use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Resources\Menu\Pages\Create;
use Abacus\Filament\Resources\Menu\Pages\Edit;
use Abacus\Filament\Resources\Menu\Pages\Index;
use Abacus\Filament\Resources\Menu\Relations\Items;
use Abacus\Filament\Tables\BaseTable;
use Abacus\Menu\Models\Menu as MenuModel;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = MenuModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-view-columns';
    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel() : string { return __( 'Menus' ); }
    public static function getNavigationGroup() : string { return __( 'Settings' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Menu name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Unique identifier' ) )->required()->maxLength( 255 ),

            Toggle::make( 'is_active' )->label( __( 'Active' ) )->default( true )->required()
        ] );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Menu name' ) )->sortable()->searchable(),

            TextColumn::make( 'slug' )->label( __( 'Unique identifier' ) )->searchable(),

            TextColumn::make( 'items_count' )->label( __( 'Items' ) )->counts( 'items' ),

            ToggleColumn::make( 'is_active' )->label( __( 'Active' ) )
        ] ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }

    public static function getRelations() : array {
        return [ Items::class ];
    }
}
