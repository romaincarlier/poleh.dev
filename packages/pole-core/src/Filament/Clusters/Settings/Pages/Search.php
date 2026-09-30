<?php
namespace Modules\Pole\Core\Filament\Clusters\Settings\Pages;

use Abacus\Filament\Clusters\Settings as SettingsCluster;
use Abacus\Filament\Forms\BaseForm;
use Modules\Pole\Core\Settings\Search as SearchSettings;

use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;

use BackedEnum;

class Search extends SettingsPage {
    protected static string $settings = SearchSettings::class;
    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 12;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-magnifying-glass';

    public static function getNavigationLabel() : string { return __( 'Search' ); }
    public function getTitle() : string { return __( 'Search' ); }
    public function getSubheading() : string { return __( 'Configure the predefined search terms shown in the search panel.' ); }

    public function form( Schema $schema ) : Schema {
        return $schema->components( [
            BaseForm::polyglot_tags( 'predefined_terms', __( 'Predefined terms' ) )
        ] );
    }
}
