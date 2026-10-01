<?php
namespace Modules\Pole\Core\Http\Controllers\Faq;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Glossary;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Frequently asked questions' ];

    public function __invoke() : View {
        $this->crumb( route( 'faq.index' ), __( 'Frequently asked questions' ) );

        return $this->view( 'pole-core::faq.index', [
            'glossaries' => $this->glossaries()
        ] );
    }

    protected function glossaries() : Collection {
        // A glossary without a slug for the current locale can't generate a faq.show URL - skip
        // it rather than 500 the whole index for every visitor over one incomplete record.
        return Glossary::withCount( 'questions' )->orderBy( 'order' )->get()
            ->filter( fn ( Glossary $glossary ) => filled( $glossary->slug ) )
            ->values();
    }
}
