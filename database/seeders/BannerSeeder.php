<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title' => 'Homepage Hero Banner',
            'heading' => 'Fusion <span class="title-color">Tech</span> Solution',
            'paragraph' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam placerat tincidunt orci, sed hendrerit felis ultricies non. Pellentesque metus dui, blandit quis quam eget, semper maximus magna. Duis elementum cursus nulla, a rutrum velit pretium in. In eget dignissim ante. Praesent dignissim magna at imperdiet pellentesque.',
            'button_text' => 'Contact Us',
            'button_link' => '/contact',
            'button_target' => '_self',
            'button_color' => '#000000',
            'text_alignment' => 'left',
            'text_color' => '#ffffff',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Services Banner',
            'heading' => 'Transform Your <span class="title-color">Digital</span> Presence',
            'paragraph' => 'Comprehensive digital solutions tailored to your business needs. From AI-driven strategies to cutting-edge development.',
            'button_text' => 'Explore Services',
            'button_link' => '/services',
            'button_target' => '_self',
            'button_color' => '#FF6B6B',
            'text_alignment' => 'center',
            'text_color' => '#ffffff',
            'order' => 2,
            'is_active' => false,
        ]);
    }
}