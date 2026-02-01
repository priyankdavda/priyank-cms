<?php

namespace Database\Seeders;

use App\Models\WhoWeAre;
use Illuminate\Database\Seeder;

class WhoWeAreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'heading' => 'Our Vision',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/vision.jpg',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'heading' => 'Core Values',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/value.jpg',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'heading' => 'Our Mission',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/mission.jpg',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'heading' => 'Ai-Driven',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/ai-driven.jpg',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'heading' => 'Our Approach',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/approach.jpg',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'heading' => 'Performance & Trust',
                'description' => "Drive measurable business growth\nUse AI-powered digital strategies\nFocus on leads, sales, and ROI\nDeliver long-term marketing success",
                'image' => 'img/about/performance-trust.jpg',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($items as $item) {
            WhoWeAre::create($item);
        }
    }
}
