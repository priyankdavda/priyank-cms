<?php

use App\Helpers\SeoHelper;

if (!function_exists('page_seo')) {
    /**
     * Get SEO settings for a specific page
     * 
     * Usage:
     * - page_seo('home') - Returns the full PageSeo object
     * - page_seo('home', 'title') - Returns just the title
     * - page_seo('home', 'title', 'Default Title') - Returns title with fallback
     * 
     * @param string $pageIdentifier
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function page_seo(string $pageIdentifier, ?string $key = null, $default = null)
    {
        if ($key === null) {
            return SeoHelper::get($pageIdentifier);
        }

        return SeoHelper::getValue($pageIdentifier, $key, $default);
    }
}
