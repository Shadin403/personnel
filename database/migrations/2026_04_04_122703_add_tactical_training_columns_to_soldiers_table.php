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
            $table->json('night_firing_records')->nullable()->after('firing_records');
            $table->json('night_trainings')->nullable()->after('field_trainings_winter');
            $table->json('group_trainings')->nullable()->after('night_trainings');
            $table->json('cycle_ending_exercises')->nullable()->after('group_trainings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn([
                'night_firing_records',
                'night_trainings',
                'group_trainings',
                'cycle_ending_exercises'
            ]);
        });
    }
};
