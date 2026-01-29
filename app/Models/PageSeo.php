<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageSeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_identifier',
        'page_name',
        'page_url',
        'title',
        'meta_description',
        'canonical',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'meta_keywords',
        'meta_robots',
        'schema_markup',
        'is_active',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'schema_markup' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when SEO settings are created or updated
        static::saved(function ($pageSeo) {
            Cache::forget('page_seo_' . $pageSeo->page_identifier);
        });

        static::deleted(function ($pageSeo) {
            Cache::forget('page_seo_' . $pageSeo->page_identifier);
        });
    }

    /**
     * Get SEO settings for a specific page
     */
    public static function getByIdentifier(string $identifier): ?self
    {
        return Cache::remember(
            'page_seo_' . $identifier,
            now()->addDay(),
            fn() => static::where('page_identifier', $identifier)
                ->where('is_active', true)
                ->first()
        );
    }

    /**
     * Get the title with fallback
     */
    public function getTitle(): string
    {
        return $this->title ?? $this->page_name;
    }

    /**
     * Get the OG title with fallback
     */
    public function getOgTitle(): string
    {
        return $this->og_title ?? $this->title ?? $this->page_name;
    }

    /**
     * Get the OG description with fallback
     */
    public function getOgDescription(): ?string
    {
        return $this->og_description ?? $this->meta_description;
    }

    /**
     * Get the Twitter title with fallback
     */
    public function getTwitterTitle(): string
    {
        return $this->twitter_title ?? $this->title ?? $this->page_name;
    }

    /**
     * Get the Twitter description with fallback
     */
    public function getTwitterDescription(): ?string
    {
        return $this->twitter_description ?? $this->meta_description;
    }

    /**
     * Scope to get active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
