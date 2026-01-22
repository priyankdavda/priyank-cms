<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories and keep a map of name => id
        $categoryMap = collect([
            [
                'name' => 'Chatbot Tips',
                'description' => 'Tips and tricks for chatbot implementation',
                'order' => 1,
            ],
            [
                'name' => 'AI Business',
                'description' => 'AI trends and business applications',
                'order' => 2,
            ],
            [
                'name' => 'SEO',
                'description' => 'Search Engine Optimization strategies',
                'order' => 3,
            ],
            [
                'name' => 'Automation',
                'description' => 'Business automation solutions',
                'order' => 4,
            ],
        ])->mapWithKeys(function ($data) {
            $category = Category::firstOrCreate(
                ['name' => $data['name']],
                $data
            );

            return [$data['name'] => $category->id];
        });

        // Create blogs
        $blogs = [
            [
                'title' => 'AI chatbots vs human support – which is best?',
                'excerpt' => 'Discover the pros and cons of AI chatbots versus human customer support and find the right balance for your business.',
                'content' => '<h2>Introduction</h2><p>...</p>',
                'category' => 'Chatbot Tips',
                'author' => 'John Doe',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(3),
                'meta_title' => 'AI Chatbots vs Human Support: Which is Best?',
                'meta_description' => 'Compare AI chatbots and human support...',
                'meta_keywords' => ['AI chatbots', 'customer support', 'automation'],
            ],
            [
                'title' => 'How E-commerce brands use AI to increase sales',
                'excerpt' => 'Learn how leading e-commerce brands leverage artificial intelligence.',
                'content' => '<h2>AI in E-commerce</h2><p>...</p>',
                'category' => 'AI Business',
                'author' => 'Jane Smith',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(10),
                'meta_title' => 'How E-commerce Brands Use AI to Increase Sales',
                'meta_description' => 'Discover proven AI strategies...',
                'meta_keywords' => ['e-commerce', 'AI', 'sales'],
            ],
            [
                'title' => 'Future of AI-driven SEO strategies',
                'excerpt' => 'Explore emerging AI technologies that are reshaping SEO.',
                'content' => '<h2>AI and SEO</h2><p>...</p>',
                'category' => 'SEO',
                'author' => 'Mike Johnson',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(17),
                'meta_title' => 'Future of AI-Driven SEO Strategies',
                'meta_description' => 'Stay ahead with AI-powered SEO strategies.',
                'meta_keywords' => ['SEO', 'AI'],
            ],
            [
                'title' => 'How automation improves customer experience',
                'excerpt' => 'Discover how business automation enhances customer satisfaction.',
                'content' => '<h2>The Power of Automation</h2><p>...</p>',
                'category' => 'Automation',
                'author' => 'Sarah Williams',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(25),
                'meta_title' => 'How Automation Improves Customer Experience',
                'meta_description' => 'Learn how business automation can enhance CX.',
                'meta_keywords' => ['automation', 'customer experience'],
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create([
                ...collect($blogData)->except('category')->toArray(),
                'category_id' => $categoryMap[$blogData['category']],
            ]);
        }
    }
}
