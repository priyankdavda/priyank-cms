<?php

namespace App\Helpers;

use App\Models\PageSeo;

class SeoHelper
{
    /**
     * Get SEO settings for a specific page
     * 
     * @param string $pageIdentifier The page identifier (e.g., 'home', 'about-us')
     * @return PageSeo|null
     */
    public static function get(string $pageIdentifier): ?PageSeo
    {
        return PageSeo::getByIdentifier($pageIdentifier);
    }

    /**
     * Get a specific SEO value for a page
     * 
     * @param string $pageIdentifier The page identifier
     * @param string $key The SEO field to retrieve
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public static function getValue(string $pageIdentifier, string $key, $default = null)
    {
        $seo = self::get($pageIdentifier);
        
        if (!$seo) {
            return $default;
        }

        // Use getter methods if available
        $method = 'get' . str_replace('_', '', ucwords($key, '_'));
        if (method_exists($seo, $method)) {
            return $seo->$method() ?? $default;
        }

        return $seo->$key ?? $default;
    }

    /**
     * Get title for a page
     */
    public static function getTitle(string $pageIdentifier, $default = null): ?string
    {
        return self::getValue($pageIdentifier, 'title', $default);
    }

    /**
     * Get meta description for a page
     */
    public static function getMetaDescription(string $pageIdentifier, $default = null): ?string
    {
        return self::getValue($pageIdentifier, 'meta_description', $default);
    }

    /**
     * Get canonical URL for a page
     */
    public static function getCanonical(string $pageIdentifier, $default = null): ?string
    {
        return self::getValue($pageIdentifier, 'canonical', $default);
    }

    /**
     * Get OG title for a page
     */
    public static function getOgTitle(string $pageIdentifier, $default = null): ?string
    {
        $seo = self::get($pageIdentifier);
        return $seo ? $seo->getOgTitle() : $default;
    }

    /**
     * Get OG description for a page
     */
    public static function getOgDescription(string $pageIdentifier, $default = null): ?string
    {
        $seo = self::get($pageIdentifier);
        return $seo ? $seo->getOgDescription() : $default;
    }

    /**
     * Get Twitter title for a page
     */
    public static function getTwitterTitle(string $pageIdentifier, $default = null): ?string
    {
        $seo = self::get($pageIdentifier);
        return $seo ? $seo->getTwitterTitle() : $default;
    }

    /**
     * Get Twitter description for a page
     */
    public static function getTwitterDescription(string $pageIdentifier, $default = null): ?string
    {
        $seo = self::get($pageIdentifier);
        return $seo ? $seo->getTwitterDescription() : $default;
    }
}
