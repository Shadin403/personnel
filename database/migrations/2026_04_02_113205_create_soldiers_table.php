<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soldiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number')->unique();
            $table->string('rank')->nullable();
            $table->string('user_type')->default('CO'); // CO, Staff, etc.
            $table->string('company')->nullable(); // Coy
            $table->string('appointment')->nullable(); // Appt
            $table->string('batch')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('home_district')->nullable();
            $table->string('photo')->nullable();

            // IPFT (Biannual)
            $table->string('ipft_biannual_1')->nullable();
            $table->string('ipft_biannual_2')->nullable();

            // Shooting stats
            $table->string('shoot_ret')->nullable();   // Shoot to hit
            $table->string('shoot_ap')->nullable();
            $table->string('shoot_ets')->nullable();
            $table->string('shoot_total')->nullable();

            // Other training
            $table->string('speed_march')->nullable();
            $table->string('grenade_fire')->nullable();

            // Course / Commander status
            $table->string('course_status')->nullable();
            $table->string('commander_status')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soldiers');
    }
};
