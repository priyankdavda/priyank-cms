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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable();

            // Featured Image
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();

            // Page Settings
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('template')->default('default');
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->integer('order')->default(0);

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('meta_robots')->nullable(); // index,follow / noindex,nofollow

            // Open Graph (Facebook/WhatsApp)
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');

            // Twitter Card
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_card')->default('summary_large_image');

            // Schema.org JSON-LD
            $table->json('schema_markup')->nullable();

            // Advanced
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->json('custom_fields')->nullable();

            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
