<?php
namespace Abacus\Support\Seo;

use Abacus\Settings\General;

class Resolver {
    public function resolve( ?Data $override, ?Data $model, ?Data $controller ) : Data {
        $site = $this->from_general_settings( app( General::class ) );

        return collect( [ $override, $model, $controller, $site ] )
            ->filter()
            ->reduce( fn ( ?Data $carry, Data $tier ) => $carry ? $carry->merge( $tier ) : $tier );
    }

    protected function from_general_settings( General $settings ) : Data {
        return new Data(
            title: $settings->default_meta_title ?: $settings->site_name,
            description: $settings->default_meta_description,
            robots: 'index, follow',
            opengraph_title: $settings->default_meta_title ?: $settings->site_name,
            opengraph_description: $settings->default_meta_description,
            opengraph_image: $settings->default_meta_image ? asset( 'storage/' . $settings->default_meta_image ) : null,
            url: url()->current()
        );
    }
}
