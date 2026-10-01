<?php
namespace Modules\Pole\PTJS\View\Components\Sections;

use Modules\Pole\PTJS\Models\Section;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

// "Other sections" listing, reused on every section page - hardcoded per plan.txt.
class Listing extends Component {
    public Collection $sections;

    public function __construct( ?Section $except = null ) {
        $this->sections = Section::when( $except, fn ( $query ) => $query->where( 'id', '!=', $except->id ) )
            ->orderBy( 'order' )
            ->get();
    }

    public function render() {
        return view( 'pole-ptjs::components.sections.listing' );
    }
}
