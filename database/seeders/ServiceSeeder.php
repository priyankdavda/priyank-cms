<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories first
        $categories = collect([
            'digital_marketing' => ['name' => 'Digital Marketing', 'order' => 1],
            'development'       => ['name' => 'Development', 'order' => 2],
            'design'            => ['name' => 'Design', 'order' => 3],
            'ai_services'       => ['name' => 'AI Services', 'order' => 4],
        ])->map(function ($category) {
            return ServiceCategory::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'order' => $category['order'],
                'is_active' => true,
            ]);
        });

        // Create services
        $services = [
            [
                'title' => 'AI-driven SEO & AEO',
                'short_description' => 'Use AI to target audiences, personalize campaigns, and analyze data for better engagement and results.',
                'description' => '<p>Our AI-driven SEO and AEO services leverage cutting-edge artificial intelligence to optimize your online presence. We analyze search patterns, user behavior, and market trends to create highly targeted strategies that improve your visibility and drive organic traffic.</p>',
                'category_id' => $categories['ai_services']->id, // AI Services
                'price' => 999.00,
                'price_type' => 'starting_from',
                'duration' => 'Monthly',
                'features' => [
                    ['feature' => 'AI-powered keyword research'],
                    ['feature' => 'Automated content optimization'],
                    ['feature' => 'Voice search optimization'],
                    ['feature' => 'Predictive analytics'],
                    ['feature' => 'Monthly performance reports'],
                ],
                'order' => 6,
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Lead Generation',
                'short_description' => 'We turn complex data into clear, actionable insights using AI and advanced analytics.',
                'description' => '<p>Transform your business with data-driven lead generation strategies. Our advanced analytics and AI-powered tools help you identify, attract, and convert high-quality leads consistently.</p>',
                'category_id' => $categories['digital_marketing']->id, // Digital Marketing
                'price' => 1499.00,
                'price_type' => 'starting_from',
                'duration' => 'Monthly',
                'features' => [
                    ['feature' => 'Targeted lead identification'],
                    ['feature' => 'Multi-channel campaigns'],
                    ['feature' => 'Lead scoring and qualification'],
                    ['feature' => 'CRM integration'],
                    ['feature' => 'Performance tracking'],
                ],
                'order' => 5,
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Brand & Social Management',
                'short_description' => 'We create intelligent brand strategies and manage social platforms effectively.',
                'description' => '<p>Build a powerful brand presence across all social media platforms. Our comprehensive management services ensure consistent messaging, engaging content, and meaningful interactions with your audience.</p>',
                'category_id' => $categories['digital_marketing']->id, // Digital Marketing
                'price' => 799.00,
                'price_type' => 'starting_from',
                'duration' => 'Monthly',
                'features' => [
                    ['feature' => 'Social media strategy'],
                    ['feature' => 'Content creation and scheduling'],
                    ['feature' => 'Community management'],
                    ['feature' => 'Brand monitoring'],
                    ['feature' => 'Analytics and reporting'],
                ],
                'order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'published_at' => now(),
            ],
            [
                'title' => 'AI Graphics & Videos',
                'short_description' => 'AI-powered visuals and video content for impactful brand communication.',
                'description' => '<p>Create stunning visual content with the power of AI. From graphics to videos, we produce high-quality, engaging content that captures attention and drives engagement.</p>',
                'category_id' =>  $categories['design']->id, // Design
                'price' => 599.00,
                'price_type' => 'starting_from',
                'duration' => 'Per project',
                'features' => [
                    ['feature' => 'AI-generated graphics'],
                    ['feature' => 'Video editing and production'],
                    ['feature' => 'Motion graphics'],
                    ['feature' => 'Brand-consistent designs'],
                    ['feature' => 'Multiple format exports'],
                ],
                'order' => 3,
                'is_active' => true,
                'is_featured' => false,
                'published_at' => now(),
            ],
            [
                'title' => 'Web Development',
                'short_description' => 'Custom, scalable and performance-driven web development solutions.',
                'description' => '<p>Build powerful, scalable web applications with our expert development team. We create custom solutions that are fast, secure, and designed to grow with your business.</p>',
                'category_id' =>  $categories['development']->id, // Development
                'price' => 2499.00,
                'price_type' => 'starting_from',
                'duration' => 'Per project',
                'features' => [
                    ['feature' => 'Custom web applications'],
                    ['feature' => 'Responsive design'],
                    ['feature' => 'API development'],
                    ['feature' => 'Database optimization'],
                    ['feature' => 'Ongoing maintenance'],
                ],
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Digital Marketing',
                'short_description' => 'Data-driven digital marketing strategies to boost growth and visibility.',
                'description' => '<p>Comprehensive digital marketing solutions that drive results. We combine SEO, PPC, content marketing, and social media to create integrated campaigns that deliver ROI.</p>',
                'category_id' => $categories['digital_marketing']->id, // Digital Marketing
                'price' => 1299.00,
                'price_type' => 'starting_from',
                'duration' => 'Monthly',
                'features' => [
                    ['feature' => 'Multi-channel campaigns'],
                    ['feature' => 'SEO optimization'],
                    ['feature' => 'PPC management'],
                    ['feature' => 'Content marketing'],
                    ['feature' => 'Analytics and reporting'],
                ],
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}