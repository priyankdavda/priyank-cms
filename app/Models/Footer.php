<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Footer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
        'services',
        'information',
        'resources',
        'social_links',
        'contact_info',
        'copyright_text',
        'copyright_year',
    ];

    protected $casts = [
        'services' => 'array',
        'information' => 'array',
        'resources' => 'array',
        'social_links' => 'array',
        'contact_info' => 'array',
        'is_active' => 'boolean',
        'copyright_year' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Ensure only one active footer at a time
        static::saving(function ($footer) {
            if ($footer->is_active) {
                static::where('id', '!=', $footer->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    // Scope to get active footer
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method to get active footer
    public static function getActive()
    {
        return static::active()->first();
    }
}