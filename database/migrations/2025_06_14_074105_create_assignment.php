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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade'); // Menghubungkan dengan tabel tasks
            // $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Menghubungkan dengan tabel students (misalnya)
            // $table->string('folder_path')->nullable(); 
            // $table->decimal('nilai', 5, 2)->nullable();
            // $table->timestamps();
            $table->foreignId('class_room_id')->constrained('class_rooms')->onDelete('cascade');  // Menghubungkan dengan tabel tasks $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Menghubungkan dengan tabel students
            $table->string('name'); // Nama tugas
            $table->text('description'); // Deskripsi tugas
            $table->string('attachment')->nullable();
            $table->date('due_date'); // Tanggal pengumpulan tugas
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
