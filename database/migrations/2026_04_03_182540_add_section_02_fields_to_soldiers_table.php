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
            $table->string('father_name')->nullable()->after('permanent_address');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('spouse_name')->nullable()->after('mother_name');
            $table->string('religion')->nullable()->after('spouse_name');
            $table->string('marital_status')->nullable()->after('religion');
            $table->date('dob')->nullable()->after('marital_status');
            $table->string('nid')->nullable()->after('dob');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soldiers', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name', 'spouse_name', 'religion', 'marital_status', 'dob', 'nid']);
        });
    }
};
