<?php
namespace Abacus\Concerns;

use Abacus\Models\SEO;
use Abacus\Support\Seo\Data;

use Illuminate\Database\Eloquent\Relations\MorphOne;

use Illuminate\Support\Str;

/**
 * @property string|null $title
 * @property string|null $name
 * @property string|null $excerpt
 * @property string|null $description
 * @method string|null media()
 */
trait HasSeo {
    public function seo() : MorphOne {
        return $this->morphOne( SEO::class, 'seoable' );
    }

    public function seo_data() : Data {
        $seo = $this->seo;

        return new Data(
            title: $seo?->meta_title ?: ( $this->title ?? $this->name ?? null ),
            description: $seo?->meta_description ?: Str::limit( strip_tags( $this->excerpt ?? $this->description ?? '' ), 160, '' ),
            keywords: $seo?->meta_keywords,
            robots: $seo?->meta_robots ?: 'index, follow',
            og_title: $seo?->opengraph_title ?: $seo?->meta_title,
            og_description: $seo?->opengraph_description ?: $seo?->meta_description,
            og_image: $seo?->opengraph_image
                ? asset( 'storage/' . $seo->opengraph_image )
                : ( method_exists( $this, 'media' ) ? $this->media() : null )
        );
    }
}
