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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            
            // Services Section
            $table->json('services')->nullable()->comment('Services links and titles');
            
            // Information Section
            $table->json('information')->nullable()->comment('Information links');
            
            // Resources Section
            $table->json('resources')->nullable()->comment('Resources links');
            
            // Social Media Links
            $table->json('social_links')->nullable()->comment('Social media links');
            
            // Contact Information
            $table->json('contact_info')->nullable()->comment('Address, phone, email');
            
            // Footer Bottom
            $table->string('copyright_text')->nullable();
            $table->integer('copyright_year')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
