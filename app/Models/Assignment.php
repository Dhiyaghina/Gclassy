<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'student_id', 'folder_path', 'file_path', 'nilai'];

    // Relasi ke task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
