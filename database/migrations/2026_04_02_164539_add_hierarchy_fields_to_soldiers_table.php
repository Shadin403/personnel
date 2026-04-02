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
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->string('unit_type')->nullable()->after('parent_id'); // company, platoon, soldier, etc.

            $table->foreign('parent_id')->references('id')->on('soldiers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'unit_type']);
        });
    }
};
