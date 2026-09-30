<?php
namespace Modules\PoleH\Core\View\Components\Call;

use Illuminate\View\Component;

// "Need help? Have a question?" CTA - hardcoded per plan.txt, reused across nearly every page.
class Help extends Component {
    public function render() {
        return view( 'poleh-core::components.call.help' );
    }
}
