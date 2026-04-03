<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('type'); // battalion, company, platoon, section
            $table->string('appointment')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('units')->onDelete('cascade');
        });

        // Add unit_id to soldiers table
        Schema::table('soldiers', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->after('id');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
        Schema::dropIfExists('units');
    }
};
