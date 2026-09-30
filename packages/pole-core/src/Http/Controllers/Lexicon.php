<?php
namespace Modules\Pole\Core\Http\Controllers;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Definition;
use Modules\Pole\Core\Settings\Copywriting;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Lexicon extends Controller {
    protected static array $seo = [ 'title' => 'Lexicon' ];

    public function __invoke() : View {
        $this->crumb( route( 'lexicon.index' ), __( 'Lexicon' ) );

        return $this->view( 'pole-core::lexicon.index', [
            'settings' => app( Copywriting::class ),
            'definitions_by_letter' => $this->definitions_by_letter()
        ] );
    }

    protected function definitions_by_letter() : Collection {
        return Definition::orderBy( 'term' )->get()
            ->groupBy( fn ( Definition $definition ) => Str::upper( Str::substr( $definition->term, 0, 1 ) ) )
            ->sortKeys();
    }
}
