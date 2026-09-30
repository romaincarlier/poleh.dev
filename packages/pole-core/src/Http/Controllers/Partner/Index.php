<?php
namespace Modules\Pole\Core\Http\Controllers\Partner;

use Abacus\Http\Controllers\Controller;
use Modules\Pole\Core\Models\Partner;
use Modules\Pole\Core\Models\Partner\Category;
use Modules\Pole\Core\Settings\Copywriting;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Partners' ];

    public function __invoke() : View {
        $this->crumb( route( 'partner.index' ), __( 'Partners' ) );

        return $this->view( 'pole-core::partner.index', [
            'settings' => app( Copywriting::class ),
            'categories' => Category::orderBy( 'order' )->get(),
            'partners' => $this->partners()
        ] );
    }

    protected function partners() : Collection {
        return Partner::orderBy( 'order' )->get();
    }
}
