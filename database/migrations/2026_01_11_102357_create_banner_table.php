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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('heading');
            $table->text('paragraph')->nullable();
            $table->string('background_image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->enum('button_target', ['_self', '_blank'])->default('_self');
            $table->string('text_alignment')->default('left'); // left, center, right
            $table->string('text_color')->default('#ffffff');
            $table->string('button_color')->default('#000000');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner');
    }
};
