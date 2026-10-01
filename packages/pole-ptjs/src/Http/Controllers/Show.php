<?php
namespace Modules\Pole\PTJS\Http\Controllers;

use Modules\Pole\PTJS\Models\Section;

use Illuminate\View\View;

class Show extends Controller {
    public function __invoke( int $id, string $slug = '' ) : View {
        $section = Section::find_by_composed_slug_or_fail( $id, $slug );

        $this->seo( $section, [ 'url' => route( 'ptjs.show', $section->route_parameters() ) ] );
        $this->crumb( route( 'ptjs.show', $section->route_parameters() ), $section->crumb_title() );

        return $this->view( 'pole-ptjs::ptjs.show', [
            'section' => $section
        ] );
    }
}
