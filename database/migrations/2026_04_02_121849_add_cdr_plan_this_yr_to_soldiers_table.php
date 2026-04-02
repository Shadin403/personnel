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
            $table->string('cdr_plan_this_yr')->nullable()->after('course_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn('cdr_plan_this_yr');
        });
    }
};
