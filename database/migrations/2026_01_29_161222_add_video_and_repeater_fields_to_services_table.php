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
        Schema::table('services', function (Blueprint $table) {
            $table->string('video_link')->nullable()->after('icon');
            $table->json('services')->nullable()->after('features');
            $table->json('content_blocks')->nullable()->after('services');
            $table->json('qna')->nullable()->after('content_blocks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['video_link', 'services', 'content_blocks', 'qna']);
        });
    }
};
