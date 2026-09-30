<?php
namespace Modules\PoleH\Core\Filament\Resources\Post;

use Abacus\Filament\Forms\BaseForm;
use Abacus\Filament\Resources\BaseResource;
use Abacus\Filament\Tables\BaseTable;
use Modules\PoleH\Core\Filament\Resources\Post\Pages\Create;
use Modules\PoleH\Core\Filament\Resources\Post\Pages\Edit;
use Modules\PoleH\Core\Filament\Resources\Post\Pages\Index;
use Modules\PoleH\Core\Models\Post as PostModel;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use BackedEnum;

class Resource extends BaseResource {
    protected static ?string $model = PostModel::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 30;

    public static function getNavigationLabel() : string { return __( 'Posts' ); }
    public static function getNavigationGroup() : string { return __( 'Content' ); }

    public static function form( Schema $schema ) : Schema {
        return $schema->components( [
            Group::make()->columnSpan( [ 'lg' => 3 ] )->schema( [
                Section::make( __( 'Content' ) )->schema( [
                    TextInput::make( 'title' )->label( __( 'Title' ) )->required()->maxLength( 255 )->columnSpan( 2 ),

                    TextInput::make( 'slug' )->label( __( 'Slug' ) )->required()->maxLength( 255 ),

                    Select::make( 'categories' )
                        ->label( __( 'Categories' ) )
                        ->relationship( 'categories', 'name' )
                        ->multiple()
                        ->preload()
                        ->searchable(),

                    BaseForm::uploader( 'media' )->label( __( 'Image' ) )->image()->directory( 'posts' ),

                    Toggle::make( 'is_published' )->label( __( 'Published' ) )->default( false ),

                    BaseForm::editor( 'excerpt', __( 'Excerpt' ) ),

                    BaseForm::editor( 'content', __( 'Content' ) )
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
            TextColumn::make( 'title' )->label( __( 'Title' ) )->sortable()->searchable(),

            TextColumn::make( 'categories.name' )->label( __( 'Categories' ) )->badge(),

            IconColumn::make( 'is_published' )->label( __( 'Published' ) )->boolean(),

            TextColumn::make( 'created_at' )->label( __( 'Created' ) )->dateTime( 'd/m/Y' )->sortable()
        ] )->defaultSort( 'created_at', 'desc' ) );
    }

    public static function getPages() : array {
        return [
            'index' => Index::route( '/' ),
            'create' => Create::route( '/create' ),
            'edit' => Edit::route( '/{record}/edit' )
        ];
    }
}
