<?php
namespace Modules\Pole\Core\Http\Controllers\Faq;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Glossary;

use Illuminate\View\View;

class Show extends Controller {
    public function __invoke( Glossary $glossary ) : View {
        $this->seo( $glossary, [ 'title' => $glossary->name ] );

        $this->crumb( route( 'faq.index' ), __( 'Frequently asked questions' ) );
        $this->crumb( route( 'faq.show', $glossary ), $glossary->name );

        return $this->view( 'pole-core::faq.show', [
            'glossary' => $glossary->load( 'questions' )
        ] );
    }
}
