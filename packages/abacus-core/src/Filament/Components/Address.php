<?php
namespace Abacus\Filament\Components;

use Abacus\Enums\Countries;
use Abacus\Support\Geocoding\Client;

use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class Address {
    public static function make( string $prefix ) : Component {
        $is_locked = static function ( Get $get ) use ( $prefix ) : bool {
            return ! $get( $prefix . '_unlocked' ) && filled( $get( $prefix . '_latitude' ) );
        };

        return Group::make()->columns( 12 )->columnSpanFull()->schema( [
            Group::make()->columnSpan( 7 )->schema( [
                Hidden::make( $prefix . '_unlocked' )->default( false )->dehydrated( false ),

                TextInput::make( $prefix . '_street' )->label( __( 'Street' ) )->maxLength( 255 )->columnSpan( 8 )->disabled( $is_locked ),
                TextInput::make( $prefix . '_number' )->label( __( 'Number' ) )->maxLength( 20 )->columnSpan( 4 )->disabled( $is_locked ),
                TextInput::make( $prefix . '_postal_code' )->label( __( 'Postal code' ) )->maxLength( 20 )->columnSpan( 4 )->disabled( $is_locked ),
                TextInput::make( $prefix . '_city' )->label( __( 'City' ) )->maxLength( 255 )->columnSpan( 8 )->disabled( $is_locked ),
                Select::make( $prefix . '_country' )->label( __( 'Country' ) )->options( Countries::class )->native( false )->searchable()->columnSpanFull()->disabled( $is_locked ),
                TextInput::make( $prefix . '_latitude' )->label( __( 'Latitude' ) )->numeric()->columnSpan( 6 )->disabled(),
                TextInput::make( $prefix . '_longitude' )->label( __( 'Longitude' ) )->numeric()->columnSpan( 6 )->disabled(),

                Actions::make( [
                    Action::make( $prefix . '_unlock' )
                        ->label( __( 'Edit address' ) )
                        ->icon( 'heroicon-o-lock-open' )
                        ->color( 'gray' )
                        ->visible( $is_locked )
                        ->action( fn ( Set $set ) => $set( $prefix . '_unlocked', true ) ),

                    Action::make( $prefix . '_localize' )
                        ->label( __( 'Localize' ) )
                        ->icon( 'heroicon-o-map-pin' )
                        ->action( function ( Get $get, Set $set ) use ( $prefix ) : void {
                            $query = implode( ' ', array_filter( [
                                $get( $prefix . '_street' ),
                                $get( $prefix . '_number' ),
                                $get( $prefix . '_postal_code' ),
                                $get( $prefix . '_city' ),
                                $get( $prefix . '_country' )
                            ] ) );

                            $coordinates = ( new Client() )->geocode( $query );

                            if ( ! $coordinates ) {
                                return;
                            }

                            $set( $prefix . '_latitude', $coordinates->latitude );
                            $set( $prefix . '_longitude', $coordinates->longitude );
                        } )
                ] )->columnSpanFull()
            ] ),

            ViewField::make( $prefix . '_map' )
                ->view( 'abacus::forms.components.address-map' )
                ->viewData( [ 'prefix' => $prefix ] )
                ->dehydrated( false )
                ->columnSpan( 5 )
        ] );
    }
}
