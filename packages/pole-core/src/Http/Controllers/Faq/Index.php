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
        return Glossary::withCount( 'questions' )->orderBy( 'order' )->get();
    }
}
