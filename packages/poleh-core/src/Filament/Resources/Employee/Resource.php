<?php
namespace Modules\PoleH\Core\Filament\Resources\Employee;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Modules\PoleH\Core\Filament\Resources\Employee\Pages\Manage;
use Modules\PoleH\Core\Models\Employee as EmployeeModel;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = EmployeeModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-identification';
    protected static ?int $navigationSort = 50;

    public static function getNavigationLabel() : string { return __( 'Employees' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'first_name' )->label( __( 'First name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'name' )->label( __( 'Last name' ) )->required()->maxLength( 255 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'phone' )->label( __( 'Phone number' ) )->tel()->maxLength( 255 ),

            TextInput::make( 'email' )->label( __( 'Email address' ) )->email()->maxLength( 255 ),

            BaseForm::polyglot_editor( 'description', __( 'Description' ) )
        ] )->columns( 2 );
    }

    public static function table( Table $table ) : Table {
        return $table
            ->columns( [
                TextColumn::make( 'first_name' )->label( __( 'First name' ) )->sortable()->searchable(),
                TextColumn::make( 'name' )->label( __( 'Last name' ) )->sortable()->searchable(),
                TextColumn::make( 'email' )->label( __( 'Email' ) ),
                TextColumn::make( 'phone' )->label( __( 'Phone' ) )
            ] )
            ->recordActions( [ EditAction::make(), DeleteAction::make() ] )
            ->defaultSort( 'order' )
            ->reorderable( 'order' );
    }

    public static function getPages() : array {
        return [
            'index' => Manage::route( '/' )
        ];
    }
}
