<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationItem extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'url',
        'parent_id',
        'sort_order',
        'is_active',
        'icon',
        'target',
        'css_class',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Get all children (including nested)
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order');
    }

    // Get active children only
    public function activeChildren(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    // Get parent
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Get all descendants recursively
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    // Check if item has children
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    // Get depth level
    public function getDepthLevel(): int
    {
        $level = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        
        return $level;
    }

    // Scope for root items
    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id')->orderBy('sort_order');
    }

    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get full path (breadcrumb)
    public function getFullPath(): string
    {
        $path = [$this->title];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->title);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }
}