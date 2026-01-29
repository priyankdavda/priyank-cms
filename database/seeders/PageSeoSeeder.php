<?php

namespace Database\Seeders;

use App\Models\PageSeo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'page_identifier' => 'home',
                'page_name' => 'Homepage',
                'page_url' => url('/'),
                'title' => 'Your Company Name – AI & IT Solutions',
                'meta_description' => 'Leading provider of AI-driven SEO, Web Development, Digital Marketing and IT solutions for growing businesses.',
                'canonical' => url('/'),
                'og_title' => 'Your Company Name – AI & IT Solutions',
                'og_description' => 'AI-driven digital solutions for growing businesses.',
                'twitter_title' => 'Your Company Name – AI & IT Solutions',
                'twitter_description' => 'AI-driven digital solutions for growing businesses.',
                'meta_keywords' => ['AI solutions', 'web development', 'digital marketing', 'IT services'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
            [
                'page_identifier' => 'about-us',
                'page_name' => 'About Us',
                'page_url' => url('/about-us'),
                'title' => 'About Us – Your Company Name',
                'meta_description' => 'Learn about our mission, vision, and the team behind innovative AI and IT solutions.',
                'canonical' => url('/about-us'),
                'og_title' => 'About Us – Your Company Name',
                'og_description' => 'Discover our story and commitment to excellence in technology.',
                'twitter_title' => 'About Us – Your Company Name',
                'twitter_description' => 'Discover our story and commitment to excellence in technology.',
                'meta_keywords' => ['about us', 'company history', 'team', 'mission'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
            [
                'page_identifier' => 'services',
                'page_name' => 'Services',
                'page_url' => url('/services'),
                'title' => 'Our Services – Your Company Name',
                'meta_description' => 'Explore our comprehensive range of AI, web development, digital marketing, and IT consulting services.',
                'canonical' => url('/services'),
                'og_title' => 'Our Services – Your Company Name',
                'og_description' => 'Comprehensive technology solutions tailored to your business needs.',
                'twitter_title' => 'Our Services – Your Company Name',
                'twitter_description' => 'Comprehensive technology solutions tailored to your business needs.',
                'meta_keywords' => ['services', 'IT solutions', 'web development', 'consulting'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
            [
                'page_identifier' => 'contact',
                'page_name' => 'Contact Us',
                'page_url' => url('/contact'),
                'title' => 'Contact Us – Your Company Name',
                'meta_description' => 'Get in touch with our team. We\'re here to answer your questions and discuss your project needs.',
                'canonical' => url('/contact'),
                'og_title' => 'Contact Us – Your Company Name',
                'og_description' => 'Reach out to us for inquiries, support, or project discussions.',
                'twitter_title' => 'Contact Us – Your Company Name',
                'twitter_description' => 'Reach out to us for inquiries, support, or project discussions.',
                'meta_keywords' => ['contact', 'get in touch', 'support', 'inquiries'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
            [
                'page_identifier' => 'portfolio',
                'page_name' => 'Portfolio',
                'page_url' => url('/portfolio'),
                'title' => 'Our Portfolio – Your Company Name',
                'meta_description' => 'Explore our portfolio of successful projects and case studies across various industries.',
                'canonical' => url('/portfolio'),
                'og_title' => 'Our Portfolio – Your Company Name',
                'og_description' => 'See how we\'ve helped businesses transform through technology.',
                'twitter_title' => 'Our Portfolio – Your Company Name',
                'twitter_description' => 'See how we\'ve helped businesses transform through technology.',
                'meta_keywords' => ['portfolio', 'projects', 'case studies', 'work'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
            [
                'page_identifier' => 'blog',
                'page_name' => 'Blog',
                'page_url' => url('/blog'),
                'title' => 'Blog – Your Company Name',
                'meta_description' => 'Stay updated with the latest insights, trends, and news in AI, technology, and digital transformation.',
                'canonical' => url('/blog'),
                'og_title' => 'Blog – Your Company Name',
                'og_description' => 'Technology insights and industry trends from our experts.',
                'twitter_title' => 'Blog – Your Company Name',
                'twitter_description' => 'Technology insights and industry trends from our experts.',
                'meta_keywords' => ['blog', 'articles', 'news', 'insights', 'technology'],
                'meta_robots' => 'index, follow',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            PageSeo::updateOrCreate(
                ['page_identifier' => $page['page_identifier']],
                $page
            );
        }

        $this->command->info('Page SEO settings seeded successfully!');
    }
}
