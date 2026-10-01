<?php
namespace Modules\Pole\Help\Http\Controllers;

use Abacus\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController {
    public function __construct() {
        $this->crumb( route( 'help.index' ), __( 'Aide & Precarite' ) );
    }
}
