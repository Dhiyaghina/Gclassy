<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // protected $fillable = ['task_id', 'student_id', 'folder_path', 'file_path', 'nilai'];
    protected $fillable = [
        'class_room_id',
        'name',
        'description',
        'attachment',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

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

    // Relasi ke class room
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    // Relasi ke submissions
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // Get submitted assignments count
    public function getSubmittedCountAttribute()
    {
        return $this->submissions()->count();
    }

    // Check if assignment is overdue
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now();
    }
}
