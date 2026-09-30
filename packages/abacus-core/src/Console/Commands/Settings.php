<?php
namespace Abacus\Console\Commands;

use Abacus\Settings\Settings as BaseSettings;

use Illuminate\Console\Command;

use Spatie\LaravelSettings\Factories\SettingsRepositoryFactory;
use Spatie\LaravelSettings\SettingsContainer;

class Settings extends Command {
    protected $signature = 'abacus:settings';
    protected $description = 'Insert any missing settings properties (with their declared defaults) for every discovered settings class';

    public function handle( SettingsContainer $container ) : int {
        foreach ( $container->getSettingClasses() as $class ) {
            if ( ! is_subclass_of( $class, BaseSettings::class ) ) {
                continue;
            }

            $repository = SettingsRepositoryFactory::create( $class::repository() );
            $group = $class::group();
            $defaults = $class::defaults();

            foreach ( $defaults as $name => $value ) {
                if ( $repository->checkIfPropertyExists( $group, $name ) ) {
                    continue;
                }

                $repository->createProperty( $group, $name, $value );
                $this->line( "Inserted [{$group}.{$name}]" );
            }
        }

        return self::SUCCESS;
    }
}
