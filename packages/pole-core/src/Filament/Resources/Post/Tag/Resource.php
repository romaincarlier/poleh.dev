<?php
namespace Modules\Pole\Core\Filament\Resources\Post\Tag;

use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Core\Filament\Resources\Post\Tag\Pages\Manage;
use Modules\Pole\Core\Models\Post\Tag as TagModel;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = TagModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-hashtag';
    protected static ?int $navigationSort = 32;

    public static function getNavigationLabel() : string { return __( 'Post tags' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 )
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
