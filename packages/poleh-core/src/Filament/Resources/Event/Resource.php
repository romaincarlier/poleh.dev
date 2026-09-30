<?php
namespace Modules\PoleH\Core\Filament\Resources\Event;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\PoleH\Core\Filament\Resources\Event\Pages\Create;
use Modules\PoleH\Core\Filament\Resources\Event\Pages\Edit;
use Modules\PoleH\Core\Filament\Resources\Event\Pages\Index;
use Modules\PoleH\Core\Models\Event as EventModel;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = EventModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 20;

    public static function getNavigationLabel() : string { return __( 'Events' ); }
    public static function getNavigationGroup() : string { return __( 'Events' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            Group::make()->columnSpan( [ 'lg' => 3 ] )->schema( [
                Section::make( __( 'Content' ) )->schema( [
                    TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

                    TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

                    Select::make( 'categories' )
                        ->label( __( 'Categories' ) )
                        ->relationship( 'categories', 'name' )
                        ->multiple()
                        ->preload()
                        ->searchable(),

                    BaseForm::uploader( 'image' )->label( __( 'Image' ) )->image()->directory( 'events' ),

                    TextInput::make( 'price' )->label( __( 'Price' ) )->numeric()->prefix( '€' ),

                    Toggle::make( 'is_featured' )->label( __( 'Featured' ) ),

                    BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

                    BaseForm::editor( 'description', __( 'Description' ) ),

                    BaseForm::editor( 'practical_information', __( 'Practical information' ) )
                ] )->columns( 2 ),

                Section::make( __( 'Dates' ) )->schema( [
                    DateTimePicker::make( 'event_date' )->label( __( 'Date (for calendars)' ) ),

                    TextInput::make( 'human_date' )->label( __( 'Human-readable date' ) )->helperText( __( 'E.g. "from 3 to 5 May", or "throughout July".' ) )->maxLength( 255 )
                ] )->columns( 2 ),

                Section::make( __( 'Location' ) )->schema( [
                    TextInput::make( 'custom_location' )->label( __( 'Custom location' ) )->helperText( __( 'E.g. "UMONS campus" - overrides the structured address below for display.' ) )->maxLength( 255 )->columnSpanFull(),

                    BaseForm::address( 'address' )
                ] ),

                Section::make( __( 'Practical links' ) )->schema( [
                    TextInput::make( 'info_url' )->label( __( 'Information URL' ) )->url()->maxLength( 255 ),

                    TextInput::make( 'registration_url' )->label( __( 'Registration URL' ) )->url()->maxLength( 255 ),

                    TextInput::make( 'organizer_name' )->label( __( 'Organizer name' ) )->maxLength( 255 ),

                    TextInput::make( 'organizer_email' )->label( __( 'Organizer email' ) )->email()->maxLength( 255 )
                ] )->columns( 2 ),

                BaseForm::seo()
            ] ),

            Group::make()->columnSpan( [ 'lg' => 1 ] )->schema( [
                BaseForm::breadcrumbs()
            ] )
        ] )->columns( 4 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'event_date' )->label( __( 'Date' ) )->dateTime( 'd/m/Y H:i' )->sortable(),

            TextColumn::make( 'categories.name' )->label( __( 'Categories' ) )->badge()
        ] )->defaultSort( 'event_date' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }
}
