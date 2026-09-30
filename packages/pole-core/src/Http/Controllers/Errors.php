<?php
namespace Modules\PoleH\Core\Http\Controllers;

use Abacus\Http\Controllers\Controller;
use Modules\PoleH\Core\Settings\Copywriting;

use Illuminate\View\View;

class Errors extends Controller {
    protected static array $seo = [ 'title' => 'Page not found' ];

    public function show() : View {
        $this->crumb( url()->current(), __( 'Page not found' ) );

        return $this->view( 'poleh-core::errors.404', [
            'settings' => app( Copywriting::class )
        ] );
    }
}
