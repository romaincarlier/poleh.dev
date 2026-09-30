<?php
namespace Abacus\Filament\Resources;

use Filament\Resources\Resource;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class BaseResource extends Resource {
    public static function getNavigationBadge() : ?string {
        $key = Str::lower( class_basename( static::getModel() ) ) . '_count_badge';

        return (string) Cache::remember( $key, now()->addDay(), fn () => static::getModel()::count() );
    }

    public static function get_nest_indicator( int $ancestors ) : string {
        if ( $ancestors < 1 ) {
            return '';
        }

        $margin = ( $ancestors - 1 ) * 20;

        return '<span style="display: inline-block; margin-left: ' . $margin . 'px; height: 10px; width: 10px; transform: translateY(-4px); border-width: 0 0 2px 2px; position: relative; margin-right: 10px;"></span>';
    }
}
