<?php
namespace Modules\Pole\Core\View\Components\Search;

use Modules\Pole\Core\Settings\Search;

use Illuminate\View\Component;

// Off-canvas search panel - a classic Blade component (no Livewire) per plan.txt, since it only
// needs to show/hide itself and submit a plain GET form to search.index.
class Form extends Component {
    public array $predefined_terms;

    public function __construct() {
        $settings = app( Search::class );

        $this->predefined_terms = $settings->predefined_terms[ app()->getLocale() ] ?? [];
    }

    public function render() {
        return view( 'pole-core::components.search.form' );
    }
}
