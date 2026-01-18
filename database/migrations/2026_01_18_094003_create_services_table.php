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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('service_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('icon')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_type')->nullable(); // 'fixed', 'starting_from', 'contact'
            $table->json('features')->nullable();
            $table->string('duration')->nullable();
            $table->json('meta_data')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });

        // Schema::create('service_faqs', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('service_id')->constrained()->cascadeOnDelete();
        //     $table->string('question');
        //     $table->text('answer');
        //     $table->integer('order')->default(0);
        //     $table->boolean('is_active')->default(true);
        //     $table->timestamps();
        // });

        // Schema::create('service_testimonials', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('service_id')->constrained()->cascadeOnDelete();
        //     $table->string('client_name');
        //     $table->string('client_position')->nullable();
        //     $table->string('client_company')->nullable();
        //     $table->string('client_image')->nullable();
        //     $table->text('testimonial');
        //     $table->integer('rating')->default(5);
        //     $table->integer('order')->default(0);
        //     $table->boolean('is_active')->default(true);
        //     $table->timestamps();
        // });

        // Schema::create('service_inquiries', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('service_id')->constrained()->cascadeOnDelete();
        //     $table->string('name');
        //     $table->string('email');
        //     $table->string('phone')->nullable();
        //     $table->string('company')->nullable();
        //     $table->text('message');
        //     $table->string('status')->default('new'); // 'new', 'contacted', 'converted', 'rejected'
        //     $table->text('notes')->nullable();
        //     $table->timestamp('contacted_at')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('services');

    }
};
