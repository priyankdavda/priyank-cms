<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'ACKO Insurance SEO Growth',
                'industry' => 'Insurance',
                'country' => 'India',
                'service' => 'SEO',
                'challenge' =>
                    'Low-quality backlinks, high competition, stagnant traffic',
                'results' =>
                    '99.94% organic growth. Traffic increased from 100k to 490k.',
                'keywords' => [
                    'Car insurance',
                    'Student insurance',
                    'Auto insurance',
                ],
            ],
            [
                'title' => 'PolicyBazaar Performance Campaign',
                'industry' => 'Finance',
                'country' => 'India',
                'service' => 'Digital Marketing',
                'challenge' =>
                    'Low CTR and high CPC across major keywords',
                'results' =>
                    '3.9x growth with top 3 rankings across competitive keywords.',
                'keywords' => [
                    'Health insurance',
                    'Life insurance',
                ],
            ],
        ];

        foreach ($items as $item) {
            CaseStudy::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'industry' => $item['industry'],
                'country' => $item['country'],
                'service' => $item['service'],
                'featured_image' => $item['featured_image'],
                'challenge' => $item['challenge'],
                'results' => $item['results'],
                'keywords' => $item['keywords'],
                'content' =>
                    '<p>This case study demonstrates how our strategy delivered measurable impact.</p>',
                'meta_title' => $item['title'],
                'meta_description' => Str::limit($item['results'], 155),
                'is_published' => true,
                'is_featured' => true,
                'views' => rand(100, 500),
                'completed_date' => Carbon::now()->subMonths(rand(6, 18)),
                'published_at' => now(),
            ]);
        }
    }
}
