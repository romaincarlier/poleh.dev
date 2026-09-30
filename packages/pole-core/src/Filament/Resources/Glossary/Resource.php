<?php
namespace Modules\Pole\Core\Filament\Resources\Glossary;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Core\Filament\Resources\Glossary\Pages\Create;
use Modules\Pole\Core\Filament\Resources\Glossary\Pages\Edit;
use Modules\Pole\Core\Filament\Resources\Glossary\Pages\Index;
use Modules\Pole\Core\Filament\Resources\Glossary\Relations\Questions;
use Modules\Pole\Core\Models\Glossary as GlossaryModel;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = GlossaryModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?int $navigationSort = 61;

    public static function getNavigationLabel() : string { return __( 'FAQ' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            BaseForm::polyglot_input( 'name', __( 'Name' ) ),
            BaseForm::polyglot_input( 'slug', __( 'Slug' ) ),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            BaseForm::polyglot_editor( 'description', __( 'Description' ) )
        ] );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'questions_count' )->label( __( 'Questions' ) )->counts( 'questions' )
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }

    public static function getRelations() : array {
        return [ Questions::class ];
    }
}
