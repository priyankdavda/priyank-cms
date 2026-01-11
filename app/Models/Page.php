<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'featured_image_alt',
        'status',
        'published_at',
        'template',
        'parent_id',
        'order',
        'meta_title',
        'meta_description',
        'canonical_url',
        'meta_keywords',
        'meta_robots',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_card',
        'schema_markup',
        'custom_css',
        'custom_js',
        'custom_fields',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta_keywords' => 'array',
        'schema_markup' => 'array',
        'custom_fields' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
            
            if (auth()->check()) {
                $page->created_by = auth()->id();
            }
        });

        static::updating(function ($page) {
            if (auth()->check()) {
                $page->updated_by = auth()->id();
            }
        });
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' && 
               ($this->published_at === null || $this->published_at <= now());
    }

    public function getFullUrlAttribute(): string
    {
        return url($this->slug);
    }

    // Methods
    public function generateSlug(): string
    {
        $slug = Str::slug($this->title);
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = Str::slug($this->title) . '-' . $count++;
        }

        return $slug;
    }

    public function getMetaTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description ?: $this->excerpt;
    }

    public function getOgTitle(): string
    {
        return $this->og_title ?: $this->getMetaTitle();
    }

    public function getOgDescription(): ?string
    {
        return $this->og_description ?: $this->getMetaDescription();
    }

    public function getTwitterTitle(): string
    {
        return $this->twitter_title ?: $this->getMetaTitle();
    }

    public function getTwitterDescription(): ?string
    {
        return $this->twitter_description ?: $this->getMetaDescription();
    }
}