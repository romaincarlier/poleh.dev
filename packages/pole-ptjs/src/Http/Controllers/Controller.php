<?php
namespace Modules\Pole\PTJS\Http\Controllers;

use Abacus\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController {
    public function __construct() {
        $this->crumb( route( 'ptjs.index' ), __( 'PTJS' ) );
    }
}
