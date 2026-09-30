<?php
namespace Modules\Pole\Core\Filament\Resources\Glossary\Relations;

use Abacus\Filament\Forms\BaseForm;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class Questions extends RelationManager {
    protected static string $relationship = 'questions';

    public static function getTitle( $ownerRecord, string $pageClass ) : string { return __( 'Questions' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            BaseForm::polyglot_input( 'question', __( 'Question' ) ),

            BaseForm::polyglot_editor( 'answer', __( 'Answer' ) )
        ] );
    }

    public function table( Table $table ) : Table {
        return $table
            ->recordTitleAttribute( 'question' )
            ->headerActions( [ CreateAction::make() ] )
            ->columns( [
                TextColumn::make( 'question' )->label( __( 'Question' ) )
            ] )
            ->recordActions( [ EditAction::make(), DeleteAction::make() ] )
            ->defaultSort( 'order' )
            ->reorderable( 'order' );
    }
}
