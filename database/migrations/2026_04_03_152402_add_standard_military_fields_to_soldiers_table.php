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
            $table->string('name_bn')->nullable()->after('name');
            $table->string('personal_no')->nullable()->after('number');
            $table->string('rank_bn')->nullable()->after('rank');
            $table->string('appointment_bn')->nullable()->after('appointment');
            
            // Standardizing status fields for PDF
            $table->string('ipft_1_status')->nullable();
            $table->string('ipft_2_status')->nullable();
            $table->string('ret_status')->nullable();
            $table->string('speed_march_status')->nullable();
            $table->string('grenade_firing_status')->nullable();
            $table->string('ni_firing_status')->nullable();
            
            // Hierarchy support (ensure these exist)
            if (!Schema::hasColumn('soldiers', 'company')) $table->string('company')->nullable();
            if (!Schema::hasColumn('soldiers', 'platoon')) $table->string('platoon')->nullable();
            if (!Schema::hasColumn('soldiers', 'section')) $table->string('section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn([
                'name_bn', 'rank_bn', 'appointment_bn',
                'ipft_1_status', 'ipft_2_status', 'ret_status',
                'speed_march_status', 'grenade_firing_status', 'ni_firing_status',
                'company', 'platoon', 'section'
            ]);
        });
    }
};
