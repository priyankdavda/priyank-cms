<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CaseStudy extends Model 
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'subheading',
        'featured_image',
        'category',
        'industry',
        'country',
        'service',
        'keywords',
        'results',
        'challenge',
        'challenges',
        'completed_date',
        'gallery',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'is_featured',
        'views',
        'published_at',
    ];

    protected $casts = [
        'keywords' => 'array',
        'gallery' => 'array',
        'challenges' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'completed_date' => 'date',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($caseStudy) {
            if (empty($caseStudy->slug)) {
                $caseStudy->slug = Str::slug($caseStudy->title);
            }
            
            if (empty($caseStudy->meta_title)) {
                $caseStudy->meta_title = $caseStudy->title;
            }
        });

        static::updating(function ($caseStudy) {
            if ($caseStudy->isDirty('title') && empty($caseStudy->slug)) {
                $caseStudy->slug = Str::slug($caseStudy->title);
            }
        });
    }


    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByIndustry($query, $industry)
    {
        return $query->where('industry', $industry);
    }

    // Accessors & Mutators
    public function getExcerptAttribute($length = 150)
    {
        return Str::limit(strip_tags($this->content), $length);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // Average reading speed
    }

    // Helper Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'is_published' => false,
        ]);
    }
}