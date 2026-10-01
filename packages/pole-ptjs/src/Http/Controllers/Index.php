<?php
namespace Modules\Pole\PTJS\Http\Controllers;

use Modules\Pole\PTJS\Models\Section;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Plus tard je serai' ];

    public function __invoke() : View {
        return $this->view( 'pole-ptjs::ptjs.index', [
            'sections' => $this->sections()
        ] );
    }

    protected function sections() : Collection {
        return Section::orderBy( 'order' )->get();
    }
}
