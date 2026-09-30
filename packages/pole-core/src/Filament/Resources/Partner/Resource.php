<?php
namespace Modules\Pole\Core\Filament\Resources\Partner;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\Pole\Core\Filament\Resources\Partner\Pages\Create;
use Modules\Pole\Core\Filament\Resources\Partner\Pages\Edit;
use Modules\Pole\Core\Filament\Resources\Partner\Pages\Index;
use Modules\Pole\Core\Models\Partner as PartnerModel;
use Modules\Pole\Core\Models\Partner\Category;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = PartnerModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 40;

    public static function getNavigationLabel() : string { return __( 'Partners' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            TextInput::make( 'name' )->label( __( 'Name' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

            TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

            TextInput::make( 'destination_url' )->label( __( 'Destination URL' ) )->url()->maxLength( 255 ),

            Select::make( 'partner_category_id' )
                ->label( __( 'Category' ) )
                ->options( fn () => Category::pluck( 'name', 'id' ) )
                ->searchable(),

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            TextInput::make( 'email' )->label( __( 'Email' ) )->email()->maxLength( 255 ),

            TextInput::make( 'phone' )->label( __( 'Phone' ) )->tel()->maxLength( 255 ),

            BaseForm::uploader( 'logo' )->label( __( 'Logo' ) )->image()->directory( 'partners' ),

            FileUpload::make( 'logo_vector' )->label( __( 'Vector logo (SVG)' ) )->disk( 'public' )->directory( 'partners/vector' )->acceptedFileTypes( [ 'image/svg+xml' ] ),

            BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

            BaseForm::editor( 'description', __( 'Description' ) ),

            BaseForm::editor( 'collaboration', __( 'Collaboration' ) ),

            Tabs::make()->columnSpanFull()->tabs( [
                Tab::make( __( 'Registered office' ) )->schema( [
                    BaseForm::address( 'headquarters' )
                ] ),

                Tab::make( __( 'Hainaut address' ) )->schema( [
                    BaseForm::address( 'hainaut' )
                ] )
            ] )
        ] )->columns( 2 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            ImageColumn::make( 'logo' )->label( __( 'Logo' ) )->disk( 'public' ),

            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable(),

            TextColumn::make( 'category.name' )->label( __( 'Category' ) )->placeholder( '-' )
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
