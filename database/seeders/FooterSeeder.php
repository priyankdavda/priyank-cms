<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        Footer::create([
            'name' => 'Default Website Footer',
            'is_active' => true,

            'services' => [
                ['title' => 'AI-driven SEO & AEO', 'url' => '#', 'open_new_tab' => false],
                ['title' => 'Lead Generation', 'url' => '#', 'open_new_tab' => false],
                ['title' => 'Brand & Social Management', 'url' => '#', 'open_new_tab' => false],
                ['title' => 'AI Graphics & Videos', 'url' => '#', 'open_new_tab' => false],
                ['title' => 'Web Development', 'url' => '#', 'open_new_tab' => false],
                ['title' => 'Digital Marketing', 'url' => '#', 'open_new_tab' => false],
            ],

            'information' => [
                ['title' => 'Home', 'url' => '/', 'open_new_tab' => false],
                ['title' => 'About Us', 'url' => '/about', 'open_new_tab' => false],
                ['title' => 'Portfolio', 'url' => '/portfolio', 'open_new_tab' => false],
                ['title' => 'Contact Us', 'url' => '/contact', 'open_new_tab' => false],
            ],

            'resources' => [
                ['title' => 'Blog', 'url' => '/blog', 'open_new_tab' => false],
                ['title' => 'Case Study', 'url' => '/case-studies', 'open_new_tab' => false],
            ],

            'social_links' => [
                ['platform' => 'facebook', 'url' => '#', 'icon' => 'fa-facebook'],
                ['platform' => 'twitter', 'url' => '#', 'icon' => 'fa-twitter'],
                ['platform' => 'linkedin', 'url' => '#', 'icon' => 'fa-linkedin'],
                ['platform' => 'youtube', 'url' => '#', 'icon' => 'fa-square-youtube'],
            ],

            'contact_info' => [
                'address' => [
                    'line1' => '4517 Washington',
                    'country' => 'USA',
                ],
                'phone' => '+(1)1230 452 8597',
                'email' => 'aivora@domain.com',
            ],

            'copyright_text' => 'Fusion Logic, All rights reserved.',
            'copyright_year' => 2026,
        ]);
    }
}
