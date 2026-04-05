<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->unsignedInteger('height_inch')->nullable()->after('weight');
            $table->decimal('waist_inch', 5, 2)->nullable()->after('height_inch');
            $table->decimal('hip_inch', 5, 2)->nullable()->after('waist_inch');
            $table->decimal('wrist_cm', 5, 2)->nullable()->after('hip_inch');
            $table->boolean('is_pregnant')->default(false)->after('wrist_cm');
            $table->boolean('is_athlete')->default(false)->after('is_pregnant'); // Boxer, Wrestler, Weightlifter (+20lb)
            $table->boolean('medical_not_obese')->default(false)->after('is_athlete'); // PET pass + not obese (+15lb)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn([
                'height_inch',
                'waist_inch',
                'hip_inch',
                'wrist_cm',
                'is_pregnant',
                'is_athlete',
                'medical_not_obese'
            ]);
        });
    }
};
