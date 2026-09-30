<?php
namespace Modules\PoleH\Core\Filament\Resources\Partner;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\PoleH\Core\Filament\Resources\Partner\Pages\Create;
use Modules\PoleH\Core\Filament\Resources\Partner\Pages\Edit;
use Modules\PoleH\Core\Filament\Resources\Partner\Pages\Index;
use Modules\PoleH\Core\Models\Partner as PartnerModel;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
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

            TextInput::make( 'order' )->label( __( 'Order' ) )->numeric()->default( 0 ),

            BaseForm::uploader( 'logo' )->label( __( 'Logo' ) )->image()->directory( 'partners' ),

            FileUpload::make( 'logo_vector' )->label( __( 'Vector logo (SVG)' ) )->disk( 'public' )->directory( 'partners/vector' )->acceptedFileTypes( [ 'image/svg+xml' ] ),

            BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

            BaseForm::editor( 'description', __( 'Description' ) )
        ] )->columns( 2 );
    }

    public static function table( Table $table ) : Table {
        return BaseTable::apply( $table->columns( [
            ImageColumn::make( 'logo' )->label( __( 'Logo' ) )->disk( 'public' ),

            TextColumn::make( 'name' )->label( __( 'Name' ) )->sortable()->searchable()
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
