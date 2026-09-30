<?php
namespace Modules\PoleH\Core\View\Components\Categories;

use Illuminate\View\Component;

// The 6 "portal" blocks (Information & guidance, Student support, Wellbeing & anti-harassment,
// International, Sport & culture, Education & research) - hardcoded per plan.txt, reused on the
// homepage and the 404 page.
class Portals extends Component {
    public array $portals;

    public function __construct() {
        $this->portals = [
            [ 'title' => __( 'Information & guidance' ), 'url' => '#' ],
            [ 'title' => __( 'Student support' ), 'url' => '#' ],
            [ 'title' => __( 'Wellbeing & anti-harassment' ), 'url' => '#' ],
            [ 'title' => __( 'International' ), 'url' => '#' ],
            [ 'title' => __( 'Sport & culture' ), 'url' => '#' ],
            [ 'title' => __( 'Education & research' ), 'url' => '#' ]
        ];
    }

    public function render() {
        return view( 'poleh-core::components.categories.portals' );
    }
}
