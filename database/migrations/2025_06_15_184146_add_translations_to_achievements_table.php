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
        Schema::table('achievements', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('title', 'title_ru');
            $table->renameColumn('description', 'description_ru');
            
            // Add new translation columns as nullable
            $table->string('title_kk')->nullable()->after('title_ru');
            $table->string('title_en')->nullable()->after('title_kk');
            $table->text('description_kk')->nullable()->after('description_ru');
            $table->text('description_en')->nullable()->after('description_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            // Remove translation columns
            $table->dropColumn(['title_kk', 'title_en', 'description_kk', 'description_en']);
            
            // Rename back to original
            $table->renameColumn('title_ru', 'title');
            $table->renameColumn('description_ru', 'description');
        });
    }
};
