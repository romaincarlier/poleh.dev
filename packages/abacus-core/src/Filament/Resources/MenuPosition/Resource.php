<?php
namespace Abacus\Filament\Resources\MenuPosition;

use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Resources\MenuPosition\Pages\Manage;
use Abacus\Filament\Tables\BaseTable;
use Abacus\Menu\Models\MenuPosition as MenuPositionModel;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = MenuPositionModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel() : string { return __( 'Menu positions' ); }
    public static function getNavigationGroup() : string { return __( 'Settings' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            Select::make( 'menus' )
                ->label( __( 'Menus assigned to this position' ) )
                ->relationship( 'menus', 'name' )
                ->multiple()
                ->preload()
        ] );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'slug' )->label( __( 'Slug' ) ),

            TextColumn::make( 'menus.name' )->label( __( 'Menus' ) )->badge()
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Manage::route( '/' )
        ];
    }
}
