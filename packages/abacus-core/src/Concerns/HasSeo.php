<?php
namespace Abacus\Concerns;

use Abacus\Support\Seo\Data;

use Illuminate\Support\Str;

/**
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_robots
 * @property string|null $opengraph_title
 * @property string|null $opengraph_description
 * @property string|null $opengraph_image
 * @property string|null $title
 * @property string|null $name
 * @property string|null $excerpt
 * @property string|null $description
 * @method string|null media()
 */
trait HasSeo {
    public function seo_data() : Data {
        return new Data(
            title: $this->meta_title ?: ( $this->title ?? $this->name ?? null ),
            description: $this->meta_description ?: Str::limit( strip_tags( $this->excerpt ?? $this->description ?? '' ), 160, '' ),
            keywords: $this->meta_keywords,
            robots: $this->meta_robots ?: 'index, follow',
            og_title: $this->opengraph_title ?: $this->meta_title,
            og_description: $this->opengraph_description ?: $this->meta_description,
            og_image: $this->opengraph_image
                ? asset( 'storage/' . $this->opengraph_image )
                : ( method_exists( $this, 'media' ) ? $this->media() : null )
        );
    }
}
