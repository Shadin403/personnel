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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soldier_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Commando", "BTT"
            $table->string('chance')->nullable(); // e.g. "1st", "2nd"
            $table->string('year')->nullable();
            $table->string('result')->nullable();
            $table->string('authority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
