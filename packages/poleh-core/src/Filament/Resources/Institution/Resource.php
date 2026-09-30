<?php
namespace Modules\PoleH\Core\Filament\Resources\Institution;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\PoleH\Core\Filament\Resources\Institution\Pages\Create;
use Modules\PoleH\Core\Filament\Resources\Institution\Pages\Edit;
use Modules\PoleH\Core\Filament\Resources\Institution\Pages\Index;
use Modules\PoleH\Core\Models\Institution as InstitutionModel;
use Modules\PoleH\Core\Models\Institution\Category;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = InstitutionModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?int $navigationSort = 10;

    public static function getNavigationLabel() : string { return __( 'Institutions' ); }
    public static function getNavigationGroup() : string { return __( 'Institutions' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            Group::make()->columnSpan( [ 'lg' => 3 ] )->schema( [
                Section::make( __( 'Content' ) )->schema( [
                    TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

                    TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

                    Select::make( 'institution_category_id' )
                        ->label( __( 'Category' ) )
                        ->options( fn () => Category::pluck( 'name', 'id' ) )
                        ->searchable(),

                    TextInput::make( 'website_url' )->label( __( 'Website' ) )->url()->maxLength( 255 ),

                    TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

                    Toggle::make( 'show_in_list' )->label( __( 'Show in list' ) )->default( true ),

                    BaseForm::uploader( 'logo' )->label( __( 'Logo' ) )->image()->directory( 'institutions' ),

                    BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

                    BaseForm::editor( 'description', __( 'Description' ) )
                ] )->columns( 2 ),

                Tabs::make()->tabs( [
                    Tab::make( __( 'Main address' ) )->schema( [
                        BaseForm::address( 'primary' )
                    ] ),

                    Tab::make( __( 'Hainaut address' ) )->schema( [
                        BaseForm::address( 'hainaut' )
                    ] )
                ] ),

                BaseForm::seo()
            ] ),

            Group::make()->columnSpan( [ 'lg' => 1 ] )->schema( [
                BaseForm::breadcrumbs()
            ] )
        ] )->columns( 4 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            ImageColumn::make( 'logo' )->label( __( 'Logo' ) )->disk( 'public' ),

            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'category.name' )->label( __( 'Category' ) )->placeholder( '-' ),

            ToggleColumn::make( 'show_in_list' )->label( __( 'Shown' ) )
        ] )->defaultSort( 'order' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }
}
