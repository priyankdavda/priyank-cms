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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('subheading')->nullable();
            $table->string('featured_image')->nullable();
            
            // Category & Classification
            $table->string('category')->nullable();
            $table->string('industry')->nullable();
            $table->string('country')->nullable();
            $table->string('service')->nullable();
            
            // Case Study Details
            $table->json('keywords')->nullable(); // Array of keywords
            $table->text('results')->nullable();
            $table->text('challenge')->nullable();
            $table->date('completed_date')->nullable();
            
            // Gallery (JSON format)
            $table->json('gallery')->nullable();
            
            // Content
            $table->longText('content')->nullable();
            
            // SEO Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // Status & Publishing
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
