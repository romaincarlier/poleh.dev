<?php
namespace Abacus\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;

class Polyglot extends Field {
    protected string $view = 'abacus::forms.components.polyglot';

    protected ?Field $receiver = null;

    protected function setUp() : void {
        parent::setUp();

        $this->afterStateHydrated( static function ( Polyglot $component ) : void {
            $component->hydrate_locales();
        } );
    }

    public function receiver( Field $field ) : static {
        $this->receiver = $field;

        return $this;
    }

    public function get_locales() : array {
        $plugin = filament( 'spatie-translatable' );
        $configured = $plugin->getDefaultLocales() ?: array_keys( config( 'abacus.locales' ) );
        $locales = [];

        foreach ( $configured as $locale ) {
            $locales[ $locale ] = $plugin->getLocaleLabel( $locale ) ?: config( 'abacus.locales.' . $locale, $locale );
        }

        return $locales;
    }

    public function get_locale_schema( string $locale ) : ?Schema {
        return $this->getChildSchema( 'locale_' . $locale );
    }

    protected function hydrate_locales() : void {
        $name = $this->getName();
        $locales = array_keys( $this->get_locales() );

        if ( $this->getLivewire() instanceof SettingsPage ) {
            $raw = (array) data_get( $this->getLivewire(), 'data.' . $name, [] );
        } else {
            $record = $this->getRecord();
            $raw = (array) ( $record ? $record->getTranslations( $name ) : [] );
        }

        $this->state( array_merge( array_fill_keys( $locales, '' ), $raw ) );

        foreach ( $locales as $locale ) {
            $this->childComponents( [
                $this->receiver->getClone()->statePath( $locale )->hiddenLabel()
            ], 'locale_' . $locale );
        }
    }
}
