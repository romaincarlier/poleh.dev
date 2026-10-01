<?php
namespace Modules\Pole\Help\Http\Controllers;

use Modules\Pole\Help\Models\Resource\Category;
use Modules\Pole\Help\Settings\Settings;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class Index extends Controller {
    protected static array $seo = [ 'title' => 'Aide & Precarite' ];

    public function __invoke() : View {
        return $this->view( 'pole-help::help.index', [
            'settings' => app( Settings::class ),
            'categories' => $this->top_level_categories()
        ] );
    }

    protected function top_level_categories() : Collection {
        return Category::whereNull( 'parent_id' )->orderBy( 'order' )->get();
    }
}
