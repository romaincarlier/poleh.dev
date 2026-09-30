<?php
namespace Abacus\Http\Controllers;

use Abacus\Support\Seo\Data;
use Abacus\Support\Seo\Resolver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\View as ViewContract;

abstract class Controller {
    protected static array $seo = [];

    protected ?Model $seo_model = null;
    protected ?Data $seo_override = null;

    protected array $breadcrumbs = [];

    protected function seo( ?Model $model = null, array $override = [] ) : static {
        $this->seo_model = $model;
        $this->seo_override = empty( $override ) ? null : Data::from_array( $override );

        return $this;
    }

    protected function crumb( string $url, string $title, string $method = 'add' ) : static {
        $key = Str::slug( $url . '-' . $title );

        if ( 'remove' === $method ) {
            unset( $this->breadcrumbs[ $key ] );

            return $this;
        }

        $this->breadcrumbs[ $key ] = [ 'url' => $url, 'title' => $title ];

        return $this;
    }

    protected function view( string $view, array $data = [] ) : ViewContract {
        $model_seo = ( $this->seo_model && method_exists( $this->seo_model, 'seo_data' ) )
            ? $this->seo_model->seo_data()
            : null;

        $controller_seo = empty( static::$seo ) ? null : Data::from_array( static::$seo );

        View::share( 'seo', app( Resolver::class )->resolve( $this->seo_override, $model_seo, $controller_seo ) );
        View::share( 'crumbs', $this->breadcrumbs );
        View::share( 'breadcrumbs_json_ld', $this->breadcrumbs_json_ld() );

        return view( $view, $data );
    }

    protected function breadcrumbs_json_ld() : string {
        $items = collect( $this->breadcrumbs )->values()->map( fn ( $crumb, $index ) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $crumb[ 'title' ],
            'item' => url( $crumb[ 'url' ] )
        ] );

        return json_encode( [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ], JSON_UNESCAPED_SLASHES );
    }
}
