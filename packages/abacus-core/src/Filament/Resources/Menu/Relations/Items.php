<?php
namespace Abacus\Filament\Resources\Menu\Relations;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Menu\Models\Item;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

use Illuminate\Support\Facades\Route;

class Items extends RelationManager {
    protected static string $relationship = 'items';

    public static function getTitle( $ownerRecord, string $pageClass ) : string { return __( 'Menu items' ); }

    public function form( Schema $schema ) : Schema {
        $owner = $this->getOwnerRecord();

        return $schema->components( [
            Section::make()->schema( [
                BaseForm::subheading( __( 'Item description' ) ),

                Group::make()->columns( 2 )->schema( [
                    BaseForm::polyglot_input( 'label', __( 'Label' ) ),

                    BaseForm::polyglot_input( 'link_title', __( 'Link "title" attribute' ) )
                ] ),

                Group::make()->columns( 2 )->schema( [
                    Select::make( 'parent_id' )
                        ->label( __( 'Parent item' ) )
                        ->options( fn ( $record ) => Item::where( 'menu_id', $owner->id )
                            ->when( $record, fn ( $query ) => $query->where( 'id', '!=', $record->id ) )
                            ->whereNull( 'parent_id' )
                            ->pluck( 'label', 'id' ) )
                        ->searchable(),

                    Toggle::make( 'is_active' )->label( __( 'Active' ) )->default( true )->required()
                ] )
            ] )->columns( 1 ),

            Section::make()->schema( [
                BaseForm::subheading( __( 'Link definition' ) ),

                Select::make( 'route' )
                    ->label( __( 'Predefined route' ) )
                    ->searchable()
                    ->options( fn () => $this->routes() ),

                BaseForm::polyglot_input( 'url', __( 'URL' ) )
            ] )->columns( 2 ),

            Section::make()->schema( [
                BaseForm::subheading( __( 'Advanced configuration' ) ),

                Select::make( 'link_target' )
                    ->label( __( 'Link target' ) )
                    ->options( [
                        '_self' => __( 'Same tab' ),
                        '_blank' => __( 'New tab' )
                    ] ),

                TextInput::make( 'class' )->label( __( 'Class name' ) )->maxLength( 255 )
            ] )->columns( 2 )
        ] );
    }

    protected function routes() : array {
        $routes = [];

        foreach ( Route::getRoutes() as $route ) {
            if ( ! in_array( 'GET', $route->methods() ) || str_contains( $route->uri(), '{' ) ) {
                continue;
            }

            $name = $route->getName();

            if ( ! $name || str_starts_with( $name, 'filament' ) ) {
                continue;
            }

            $routes[ $name ] = $name;
        }

        return $routes;
    }

    public function table( Table $table ) : Table {
        return $table
            ->recordTitleAttribute( 'label' )
            ->headerActions( [ CreateAction::make() ] )
            ->columns( [
                ToggleColumn::make( 'is_active' )->label( __( 'Active' ) ),

                TextColumn::make( 'label' )->label( __( 'Label' ) ),

                TextColumn::make( 'route' )->label( __( 'Route' ) )->placeholder( '-' ),

                TextColumn::make( 'destination' )->label( __( 'Destination' ) )->getStateUsing( fn ( Item $record ) => Item::destination( $record ) )
            ] )
            ->recordActions( [ EditAction::make(), DeleteAction::make() ] )
            ->defaultSort( 'order' )
            ->reorderable( 'order' );
    }
}
