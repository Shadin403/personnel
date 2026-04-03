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
        Schema::create('training_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soldier_id')->constrained()->onDelete('cascade');
            $table->string('year');
            $table->string('annual_leave')->nullable();
            $table->string('unit_training')->nullable();
            $table->string('personal_training')->nullable();
            $table->string('administration')->nullable();
            $table->string('mootw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_plans');
    }
};
