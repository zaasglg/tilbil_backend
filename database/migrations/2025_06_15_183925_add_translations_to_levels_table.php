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
        Schema::table('levels', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('name', 'name_ru');
            $table->renameColumn('description', 'description_ru');
            
            // Add new translation columns
            $table->string('name_kk')->after('name_ru');
            $table->string('name_en')->after('name_kk');
            $table->text('description_kk')->nullable()->after('description_ru');
            $table->text('description_en')->nullable()->after('description_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            // Remove translation columns
            $table->dropColumn(['name_kk', 'name_en', 'description_kk', 'description_en']);
            
            // Rename back to original
            $table->renameColumn('name_ru', 'name');
            $table->renameColumn('description_ru', 'description');
        });
    }
};
