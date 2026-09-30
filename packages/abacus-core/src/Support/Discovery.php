<?php
namespace Abacus\Support;

use Illuminate\Support\Str;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Throwable;

class Discovery {
    // Each `$paths` entry is [ 'path' => <directory>, 'namespace' => <its PSR-4 namespace> ].
    // Returns every instantiable class under those directories that is a subclass of $parent.
    public static function classes_in( array $paths, string $parent ) : array {
        $classes = [];

        foreach ( $paths as $entry ) {
            if ( ! is_dir( $entry[ 'path' ] ) ) {
                continue;
            }

            foreach ( ( new Finder() )->files()->name( '*.php' )->in( $entry[ 'path' ] ) as $file ) {
                $relative = Str::replaceLast( '.php', '', $file->getRelativePathname() );
                $class = $entry[ 'namespace' ] . '\\' . str_replace( DIRECTORY_SEPARATOR, '\\', $relative );

                if ( ! class_exists( $class ) ) {
                    continue;
                }

                try {
                    if ( is_subclass_of( $class, $parent ) && ( new ReflectionClass( $class ) )->isInstantiable() ) {
                        $classes[] = $class;
                    }
                } catch ( Throwable ) {
                    continue;
                }
            }
        }

        return $classes;
    }
}
