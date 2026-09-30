<?php
namespace Modules\Pole\Core\View\Components\Partners;

use Modules\Pole\Core\Models\Partner;

use Illuminate\View\Component;

// PHP reserves "List" as a class name, hence "Listing" here - matches plan.txt's "Partners\List"
// (partners-list) in intent, invoked as <x-pole-core::partners.listing />.
class Listing extends Component {
    public $partners;

    public function __construct() {
        $this->partners = Partner::orderBy( 'order' )->get();
    }

    public function render() {
        return view( 'pole-core::components.partners.listing' );
    }
}
