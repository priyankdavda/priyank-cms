<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_seos', function (Blueprint $table) {
            $table->id();
            $table->string('page_identifier')->unique(); // e.g., 'home', 'about-us', 'contact'
            $table->string('page_name'); // Display name, e.g., 'Homepage', 'About Us'
            $table->string('page_url')->nullable(); // Actual URL for reference
            
            // Basic SEO
            $table->string('title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical')->nullable();
            
            // Open Graph
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            
            // Twitter Card
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            
            // Additional fields
            $table->json('meta_keywords')->nullable();
            $table->string('meta_robots')->nullable(); // index,follow
            $table->json('schema_markup')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
