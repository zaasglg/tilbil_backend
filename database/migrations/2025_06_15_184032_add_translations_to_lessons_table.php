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
        Schema::table('lessons', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('title', 'title_ru');
            $table->renameColumn('content', 'content_ru');
            
            // Add new translation columns as nullable
            $table->string('title_kk')->nullable()->after('title_ru');
            $table->string('title_en')->nullable()->after('title_kk');
            $table->text('content_kk')->nullable()->after('content_ru');
            $table->text('content_en')->nullable()->after('content_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Remove translation columns
            $table->dropColumn(['title_kk', 'title_en', 'content_kk', 'content_en']);
            
            // Rename back to original
            $table->renameColumn('title_ru', 'title');
            $table->renameColumn('content_ru', 'content');
        });
    }
};
