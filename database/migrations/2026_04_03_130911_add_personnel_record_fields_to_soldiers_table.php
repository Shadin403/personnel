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
            $table->date('enrolment_date')->nullable();
            $table->date('rank_date')->nullable();
            $table->string('civil_education')->nullable();
            $table->string('weight')->nullable(); // e.g. "72 kg"
            $table->text('permanent_address')->nullable();
            $table->string('unit')->nullable();
            $table->string('sub_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn([
                'enrolment_date',
                'rank_date',
                'civil_education',
                'weight',
                'permanent_address',
                'unit',
                'sub_unit'
            ]);
        });
    }
};
