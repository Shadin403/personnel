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
            $table->string('leave_plan')->nullable()->after('commander_status');
            $table->text('sports_participation')->nullable()->after('leave_plan');
            $table->string('nil_fire')->nullable()->after('sports_participation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn(['leave_plan', 'sports_participation', 'nil_fire']);
        });
    }
};
