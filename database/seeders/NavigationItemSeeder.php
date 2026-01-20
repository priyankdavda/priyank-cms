<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationItem;

class NavigationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Home
        NavigationItem::create([
            'title' => 'Home',
            'slug' => 'home',
            'url' => '/',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // About Us
        NavigationItem::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'url' => '/about',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // FL Services (with submenu)
        $services = NavigationItem::create([
            'title' => 'FL Services',
            'slug' => 'fl-services',
            'url' => '#',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Services submenu items
        $serviceItems = [
            ['title' => 'AI-driven SEO & AEO', 'url' => '/services/ai-seo-aeo'],
            ['title' => 'Lead Generation', 'url' => '/services/lead-generation'],
            ['title' => 'Brand & Social Management', 'url' => '/services/brand-social-management'],
            ['title' => 'AI Graphics & Videos', 'url' => '/services/ai-graphics-videos'],
            ['title' => 'Web Development', 'url' => '/services/web-development'],
            ['title' => 'Digital Marketing', 'url' => '/services/digital-marketing'],
        ];

        foreach ($serviceItems as $index => $item) {
            NavigationItem::create([
                'title' => $item['title'],
                'slug' => \Illuminate\Support\Str::slug($item['title']),
                'url' => $item['url'],
                'parent_id' => $services->id,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Portfolio (with submenu)
        $portfolio = NavigationItem::create([
            'title' => 'Portfolio',
            'slug' => 'portfolio',
            'url' => '#',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        NavigationItem::create([
            'title' => 'Portfolio',
            'slug' => 'portfolio-list',
            'url' => '/portfolio',
            'parent_id' => $portfolio->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        NavigationItem::create([
            'title' => 'Portfolio Details',
            'slug' => 'portfolio-details',
            'url' => '/portfolio-details',
            'parent_id' => $portfolio->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Resources (with submenu)
        $resources = NavigationItem::create([
            'title' => 'Resources',
            'slug' => 'resources',
            'url' => '#',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        NavigationItem::create([
            'title' => 'Blog',
            'slug' => 'blog',
            'url' => '/blog',
            'parent_id' => $resources->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        NavigationItem::create([
            'title' => 'Case study',
            'slug' => 'case-study',
            'url' => '/case-study',
            'parent_id' => $resources->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Contact Us
        NavigationItem::create([
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'url' => '/contact',
            'sort_order' => 6,
            'is_active' => true,
        ]);
    }
}
