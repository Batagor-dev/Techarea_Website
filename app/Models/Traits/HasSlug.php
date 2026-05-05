<?php

namespace App\Models\Traits;

use Spatie\Sluggable\HasSlug as SpatieHasSlug;
use Spatie\Sluggable\SlugOptions;

trait HasSlug
{
    use SpatieHasSlug;

    public function getSlugOptions(): SlugOptions
    {
        // Jika model punya property slugFrom/To pakai itu, jika tidak gunakan default 'title' & 'slug'
        $from = property_exists($this, 'slugFrom') ? $this->slugFrom : 'title';
        $to = property_exists($this, 'slugTo') ? $this->slugTo : 'slug';

        return SlugOptions::create()
            ->generateSlugsFrom($from)
            ->saveSlugsTo($to);
    }
}
