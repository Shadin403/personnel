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
        Schema::table('soldiers', function (Blueprint $table) {
            $table->json('field_trainings_summer')->nullable()->after('annual_career_plans');
            $table->json('field_trainings_winter')->nullable()->after('field_trainings_summer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn(['field_trainings_summer', 'field_trainings_winter']);
        });
    }
};
