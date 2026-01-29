<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'featured_image',
        'gallery',
        'icon',
        'video_link',
        'price',
        'price_type',
        'features',
        'services',
        'content_blocks',
        'content_blocks_tagline',
        'qna',
        'qna_heading',
        'qna_tagline',
        'duration',
        'meta_data',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'order',
        'is_featured',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'gallery' => 'array',
        'features' => 'array',
        'services' => 'array',
        'content_blocks' => 'array',
        'qna' => 'array',
        'meta_data' => 'array',
        'meta_keywords' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    // public function faqs(): HasMany
    // {
    //     return $this->hasMany(ServiceFaq::class)->orderBy('order');
    // }

    // public function testimonials(): HasMany
    // {
    //     return $this->hasMany(ServiceTestimonial::class)->orderBy('order');
    // }

    // public function inquiries(): HasMany
    // {
    //     return $this->hasMany(ServiceInquiry::class)->latest();
    // }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price) {
            return 'Contact for pricing';
        }

        $formatted = '$' . number_format($this->price, 2);

        return match ($this->price_type) {
            'starting_from' => "Starting from {$formatted}",
            'contact' => 'Contact for pricing',
            default => $formatted,
        };
    }
}