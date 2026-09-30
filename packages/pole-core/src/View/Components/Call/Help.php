<?php
namespace Modules\Pole\Core\View\Components\Call;

use Illuminate\View\Component;

// "Need help? Have a question?" CTA - hardcoded per plan.txt, reused across nearly every page.
class Help extends Component {
    public function render() {
        return view( 'pole-core::components.call.help' );
    }
}
