<?php
namespace Modules\PoleH\Core\Filament\Resources\Event\Category;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\PoleH\Core\Filament\Resources\Event\Category\Pages\Manage;
use Modules\PoleH\Core\Models\Event\Category as CategoryModel;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = CategoryModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 21;

    public static function getNavigationLabel() : string { return __( 'Event categories' ); }
    public static function getNavigationGroup() : string { return __( 'Events' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

            BaseForm::editor( 'description', __( 'Description' ) )
        ] );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'order' )->label( __( 'Order' ) )->sortable()
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Manage::route( '/' )
        ];
    }
}
