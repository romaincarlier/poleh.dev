<?php
namespace Modules\Pole\Core\Filament\Resources\Definition;

use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Core\Filament\Resources\Definition\Pages\Manage;
use Modules\Pole\Core\Models\Definition as DefinitionModel;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = DefinitionModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-book-open';
    protected static ?int $navigationSort = 60;

    public static function getNavigationLabel() : string { return __( 'Definitions' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'term' )->label( __( 'Term' ) )->required()->maxLength( 255 ),

            TextInput::make( 'acronym' )->label( __( 'Acronym' ) )->maxLength( 255 ),

            Textarea::make( 'description' )->label( __( 'Description' ) )->columnSpanFull()
        ] )->columns( 2 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'term' )->label( __( 'Term' ) )->sortable()->searchable(),
            TextColumn::make( 'acronym' )->label( __( 'Acronym' ) )
        ] )->defaultSort( 'term' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Manage::route( '/' )
        ];
    }
}
