<?php
namespace Modules\PoleH\Core\View\Components\Partners;

use Modules\PoleH\Core\Models\Partner;

use Illuminate\View\Component;

// PHP reserves "List" as a class name, hence "Listing" here - matches plan.txt's "Partners\List"
// (partners-list) in intent, invoked as <x-poleh-core::partners.listing />.
class Listing extends Component {
    public $partners;

    public function __construct() {
        $this->partners = Partner::orderBy( 'order' )->get();
    }

    public function render() {
        return view( 'poleh-core::components.partners.listing' );
    }
}
