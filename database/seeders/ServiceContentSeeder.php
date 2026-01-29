<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicesData = [
            'AI-driven SEO & AEO' => [
                'content_blocks_tagline' => 'Dominate Search & AI Results',
                'qna_heading' => 'Our SEO Process That Actually Works',
                'qna_tagline' => 'How We Build SEO Results Step by Step',
                'content_blocks' => [
                    [
                        'heading' => 'Advanced AI-Powered Optimization',
                        'description' => 'Leverage cutting-edge artificial intelligence to optimize your content for both search engines and answer engines. Our AI algorithms analyze user intent and craft content that ranks higher and converts better.',
                    ],
                    [
                        'heading' => 'Answer Engine Optimization',
                        'description' => 'Get featured in AI-powered search results like ChatGPT, Gemini, and Perplexity. We optimize your content to be the preferred source for AI-generated answers, expanding your digital footprint.',
                    ],
                    [
                        'heading' => 'Real-Time Performance Tracking',
                        'description' => 'Monitor your SEO and AEO performance with our comprehensive analytics dashboard. Track keyword rankings, AI citation frequency, and organic traffic growth in real-time.',
                    ],
                    [
                        'heading' => 'Semantic Content Strategy',
                        'description' => 'Our AI develops topic clusters and semantic content strategies that establish your authority. We create interconnected content that signals expertise to both search engines and answer engines.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'What is Answer Engine Optimization (AEO)?',
                        'answer' => 'AEO is the practice of optimizing content to be featured in AI-powered answer engines like ChatGPT, Google Bard, and Perplexity AI. It focuses on providing authoritative, structured answers that AI models can cite.',
                    ],
                    [
                        'question' => 'How long does it take to see SEO results?',
                        'answer' => 'Typically, you can expect to see initial improvements in 3-4 months, with significant results in 6-12 months. However, our AI-driven approach often accelerates this timeline by identifying quick-win opportunities.',
                    ],
                    [
                        'question' => 'Do you guarantee first-page rankings?',
                        'answer' => 'While we cannot guarantee specific rankings due to search algorithm complexity, our data-driven approach consistently delivers improved visibility, traffic, and conversions for our clients.',
                    ],
                    [
                        'question' => 'What makes your AI-driven SEO different?',
                        'answer' => 'We combine traditional SEO best practices with advanced AI tools for content optimization, competitor analysis, and predictive analytics. This allows us to identify opportunities faster and execute strategies more effectively.',
                    ],
                ],
            ],
            'Lead Generation' => [
                'content_blocks_tagline' => 'Convert More Prospects Into Customers',
                'qna_heading' => 'Lead Generation Questions Answered',
                'qna_tagline' => 'Everything You Need to Know About Quality Leads',
                'content_blocks' => [
                    [
                        'heading' => 'Multi-Channel Lead Capture',
                        'description' => 'Capture high-quality leads across multiple channels including landing pages, social media, email campaigns, and paid advertising. Our integrated approach ensures no opportunity is missed.',
                    ],
                    [
                        'heading' => 'Lead Scoring & Qualification',
                        'description' => 'Implement AI-powered lead scoring to identify your hottest prospects. Our system automatically qualifies leads based on behavior, demographics, and engagement, helping your sales team focus on the best opportunities.',
                    ],
                    [
                        'heading' => 'Conversion Rate Optimization',
                        'description' => 'Continuously optimize your lead generation funnels through A/B testing, heat mapping, and user behavior analysis. We identify friction points and implement improvements to maximize conversions.',
                    ],
                    [
                        'heading' => 'CRM Integration & Automation',
                        'description' => 'Seamlessly integrate with your existing CRM and marketing automation tools. Automate lead nurturing workflows, follow-ups, and reporting to ensure no lead falls through the cracks.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'How do you ensure lead quality?',
                        'answer' => 'We use advanced targeting, lead scoring algorithms, and qualification criteria to attract and identify high-intent prospects. Our multi-touch attribution also helps refine targeting over time.',
                    ],
                    [
                        'question' => 'What is your average lead conversion rate?',
                        'answer' => 'Conversion rates vary by industry and campaign type, but our clients typically see 3-5% conversion rates for cold traffic and 15-25% for warm, targeted campaigns.',
                    ],
                    [
                        'question' => 'Do you provide leads or generate them?',
                        'answer' => 'We generate leads through strategic marketing campaigns tailored to your business. Unlike lead buying services, we build sustainable systems that generate qualified leads consistently.',
                    ],
                    [
                        'question' => 'What information do you collect from leads?',
                        'answer' => 'We collect information based on your needs, typically including name, email, phone number, company details, and qualification questions to help your sales team prioritize outreach.',
                    ],
                ],
            ],
            'Brand & Social Management' => [
                'content_blocks_tagline' => 'Build A Brand That Resonates',
                'qna_heading' => 'Your Brand & Social Media Questions',
                'qna_tagline' => 'Expert Answers to Common Social Management Questions',
                'content_blocks' => [
                    [
                        'heading' => 'Strategic Brand Positioning',
                        'description' => 'Develop a compelling brand identity that resonates with your target audience. We craft your brand story, messaging, and visual identity to create a memorable and differentiated presence in the market.',
                    ],
                    [
                        'heading' => 'Social Media Strategy & Execution',
                        'description' => 'Create and execute data-driven social media strategies across all major platforms. From content creation to community management, we handle every aspect of your social presence.',
                    ],
                    [
                        'heading' => 'Content Creation & Curation',
                        'description' => 'Produce engaging, on-brand content that drives engagement and builds community. Our team creates everything from graphics and videos to written posts and stories that align with your brand voice.',
                    ],
                    [
                        'heading' => 'Reputation Management',
                        'description' => 'Monitor and manage your online reputation across social platforms and review sites. We respond to feedback, address concerns, and amplify positive sentiment to protect and enhance your brand image.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'Which social platforms do you manage?',
                        'answer' => 'We manage all major platforms including Facebook, Instagram, LinkedIn, Twitter/X, TikTok, YouTube, and Pinterest. We recommend platforms based on where your target audience is most active.',
                    ],
                    [
                        'question' => 'How often do you post on social media?',
                        'answer' => 'Posting frequency depends on the platform and your goals, but typically ranges from 3-7 posts per week per platform. We focus on quality and engagement rather than just volume.',
                    ],
                    [
                        'question' => 'Do you handle negative comments and reviews?',
                        'answer' => 'Yes, we monitor all comments and reviews, responding professionally to both positive and negative feedback. We have protocols for crisis management and work with you to address serious concerns.',
                    ],
                    [
                        'question' => 'Can you help with influencer partnerships?',
                        'answer' => 'Absolutely! We identify relevant influencers, negotiate partnerships, manage campaigns, and track ROI to ensure your influencer marketing delivers measurable results.',
                    ],
                ],
            ],
            'AI Graphics & Videos' => [
                'content_blocks_tagline' => 'Create Stunning Visuals In Minutes',
                'qna_heading' => 'AI Content Creation FAQ',
                'qna_tagline' => 'Your Questions About AI Graphics & Video Production',
                'content_blocks' => [
                    [
                        'heading' => 'AI-Powered Visual Creation',
                        'description' => 'Harness the power of AI to create stunning graphics, illustrations, and designs in minutes. Our AI tools can generate custom visuals that match your brand style and messaging perfectly.',
                    ],
                    [
                        'heading' => 'Automated Video Production',
                        'description' => 'Create professional videos with AI-driven editing, text-to-speech, and automated b-roll selection. From social media clips to full-length promotional videos, we streamline the entire production process.',
                    ],
                    [
                        'heading' => 'Brand-Consistent Templates',
                        'description' => 'Develop AI-powered template systems that ensure brand consistency across all visual content. Generate variations quickly while maintaining your unique visual identity and design standards.',
                    ],
                    [
                        'heading' => 'Multi-Format Optimization',
                        'description' => 'Automatically optimize graphics and videos for different platforms and formats. One asset becomes multiple variations sized and formatted perfectly for Instagram, YouTube, LinkedIn, and more.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'What AI tools do you use?',
                        'answer' => 'We utilize industry-leading AI tools including Midjourney, DALL-E, Stable Diffusion for graphics, and RunwayML, Synthesia, and custom AI models for video production.',
                    ],
                    [
                        'question' => 'Can AI replace human designers?',
                        'answer' => 'AI is a powerful tool that enhances creativity but doesn\'t replace human expertise. Our designers use AI to accelerate production while applying artistic direction, brand knowledge, and strategic thinking.',
                    ],
                    [
                        'question' => 'How quickly can you deliver AI-generated content?',
                        'answer' => 'AI dramatically speeds up content creation. Simple graphics can be delivered within hours, while complex video projects typically take 2-5 days compared to weeks with traditional methods.',
                    ],
                    [
                        'question' => 'Do I own the rights to AI-generated content?',
                        'answer' => 'Yes, all AI-generated content created for your brand is yours to use. We ensure proper licensing and provide full commercial rights to all deliverables.',
                    ],
                ],
            ],
            'Web Development' => [
                'content_blocks_tagline' => 'Powerful Websites That Drive Results',
                'qna_heading' => 'Web Development Common Questions',
                'qna_tagline' => 'Learn About Our Development Process & Services',
                'content_blocks' => [
                    [
                        'heading' => 'Custom Web Applications',
                        'description' => 'Build powerful, scalable web applications tailored to your business needs. From e-commerce platforms to SaaS products, we develop solutions using modern frameworks and best practices.',
                    ],
                    [
                        'heading' => 'Responsive & Mobile-First Design',
                        'description' => 'Create beautiful, user-friendly websites that work flawlessly across all devices. Our mobile-first approach ensures optimal user experience whether visitors are on desktop, tablet, or smartphone.',
                    ],
                    [
                        'heading' => 'Performance & Security',
                        'description' => 'Develop lightning-fast, secure websites that build trust and drive conversions. We implement industry best practices for speed optimization, SSL security, and data protection.',
                    ],
                    [
                        'heading' => 'CMS Integration & Maintenance',
                        'description' => 'Integrate user-friendly content management systems that give you control over your website. We provide training, ongoing support, and regular updates to keep your site running smoothly.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'What technologies do you use?',
                        'answer' => 'We use modern tech stacks including React, Next.js, Vue.js for frontend, Laravel, Node.js for backend, and headless CMS solutions. Technology choices depend on your specific project requirements.',
                    ],
                    [
                        'question' => 'How long does web development take?',
                        'answer' => 'Timeline varies by project complexity. A basic website takes 4-6 weeks, while custom web applications can take 3-6 months. We provide detailed timelines during the planning phase.',
                    ],
                    [
                        'question' => 'Do you offer website maintenance?',
                        'answer' => 'Yes, we offer comprehensive maintenance packages including security updates, content updates, performance monitoring, and technical support to keep your website running optimally.',
                    ],
                    [
                        'question' => 'Will my website be SEO-friendly?',
                        'answer' => 'Absolutely! We build all websites with SEO best practices including clean code, fast loading speeds, mobile responsiveness, proper meta tags, and structured data markup.',
                    ],
                ],
            ],
            'Digital Marketing' => [
                'content_blocks_tagline' => 'Grow Your Business Online',
                'qna_heading' => 'Digital Marketing Questions',
                'qna_tagline' => 'Get Clear Answers About Our Marketing Services',
                'content_blocks' => [
                    [
                        'heading' => 'Comprehensive Marketing Strategy',
                        'description' => 'Develop data-driven digital marketing strategies that align with your business goals. We analyze your market, competitors, and audience to create integrated campaigns that drive measurable results.',
                    ],
                    [
                        'heading' => 'PPC & Paid Advertising',
                        'description' => 'Maximize ROI with expertly managed paid advertising campaigns across Google Ads, Facebook, Instagram, LinkedIn, and more. We optimize every dollar spent to generate qualified traffic and conversions.',
                    ],
                    [
                        'heading' => 'Email Marketing & Automation',
                        'description' => 'Build and nurture your audience with strategic email marketing campaigns. From welcome series to cart abandonment flows, we create automated sequences that engage customers and drive revenue.',
                    ],
                    [
                        'heading' => 'Analytics & Reporting',
                        'description' => 'Track performance with comprehensive analytics and transparent reporting. We provide actionable insights and regular updates on campaign performance, ROI, and opportunities for optimization.',
                    ],
                ],
                'qna' => [
                    [
                        'question' => 'What\'s included in digital marketing services?',
                        'answer' => 'Our digital marketing services include strategy development, paid advertising, email marketing, content marketing, social media marketing, conversion optimization, and analytics reporting.',
                    ],
                    [
                        'question' => 'How much should I budget for digital marketing?',
                        'answer' => 'Budget depends on your goals and industry. We typically recommend starting with $3,000-$10,000/month for small businesses, scaling as you see ROI. We work with budgets of all sizes.',
                    ],
                    [
                        'question' => 'How do you measure marketing success?',
                        'answer' => 'We track KPIs aligned with your goals including traffic, conversion rates, cost per acquisition, return on ad spend, customer lifetime value, and overall revenue impact.',
                    ],
                    [
                        'question' => 'Do you work with specific industries?',
                        'answer' => 'We have experience across various industries including e-commerce, B2B services, healthcare, technology, real estate, and more. Our strategies are customized to each industry\'s unique challenges.',
                    ],
                ],
            ],
        ];

        foreach ($servicesData as $serviceName => $data) {
            $service = Service::where('title', 'LIKE', "%{$serviceName}%")->first();
            
            if ($service) {
                $service->update([
                    'content_blocks_tagline' => $data['content_blocks_tagline'],
                    'content_blocks' => $data['content_blocks'],
                    'qna_heading' => $data['qna_heading'],
                    'qna_tagline' => $data['qna_tagline'],
                    'qna' => $data['qna'],
                ]);
                
                $this->command->info("Updated content for: {$serviceName}");
            } else {
                $this->command->warn("Service not found: {$serviceName}");
            }
        }
    }
}
