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
        Schema::table('courses', function (Blueprint $table) {
            // The courses table already has title_ru and description_ru
            // Just add the missing translation columns
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
        Schema::table('courses', function (Blueprint $table) {
            // Remove translation columns
            $table->dropColumn(['title_kk', 'title_en', 'description_kk', 'description_en']);
        });
    }
};
