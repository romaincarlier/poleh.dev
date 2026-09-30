<?php
namespace Abacus\Filament\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Table;

class BaseTable {
    public static function apply( Table $table ) : Table {
        return $table
            ->recordActions( [
                EditAction::make(),
                DeleteAction::make()
            ] )
            ->toolbarActions( [
                BulkActionGroup::make( [
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make()
                ] )
            ] )
            ->paginated( [ 10, 25, 50, 100 ] )
            ->defaultPaginationPageOption( 25 );
    }
}
