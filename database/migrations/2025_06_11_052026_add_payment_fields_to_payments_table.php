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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('amount');
            $table->string('transaction_id')->nullable()->after('payment_method');
            $table->string('payment_proof')->nullable()->after('transaction_id');
            $table->timestamp('rejected_at')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'transaction_id', 'payment_proof', 'rejected_at']);
        });
    }
};
