<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroFeatureCard extends Model
{
    protected $table = 'hero_feature_cards';

    protected $fillable = [
        'title',
        'description',
        'icon_image',
        'icon_svg',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
