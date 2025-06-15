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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Asumsi student adalah user
            $table->string('file_path')->nullable(); // Path file yang dikumpulkan
            $table->text('submission_text')->nullable(); // Teks submission jika ada
            $table->decimal('grade', 5, 2)->nullable(); // Nilai tugas
            $table->text('feedback')->nullable(); // Feedback dari guru
            $table->timestamp('submitted_at')->nullable(); // Waktu pengumpulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
