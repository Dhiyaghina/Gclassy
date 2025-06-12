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
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('employee_id')->unique()->nullable()->after('user_id');
            $table->string('qualification')->nullable()->after('subject');
            $table->string('experience')->nullable()->after('qualification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'qualification', 'experience']);
        });
    }
};
