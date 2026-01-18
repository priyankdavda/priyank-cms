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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description');
            
            // Client Information
            $table->string('client_name');
            
            // Services (comma-separated or json)
            $table->json('services');
            
            // Location/Country
            $table->json('countries'); // Can store multiple countries
            
            // Project Details
            $table->string('location')->nullable(); // e.g., "New York, USA"
            $table->date('completion_date')->nullable();
            
            // Gallery Images (JSON array of image paths)
            $table->json('gallery_images')->nullable();
            
            // Featured/Thumbnail Image
            $table->string('featured_image')->nullable();
            
            // Project Requirements (JSON array)
            $table->json('requirements')->nullable();
            
            // Solution and Results
            $table->longText('solution_description')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            

            // Status and Order
            $table->boolean('is_published')->default(true);
            $table->integer('display_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
