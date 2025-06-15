<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'submission_text',
        'grade',
        'feedback',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'grade' => 'decimal:2'
    ];

    // Relasi ke assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Relasi ke student (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Check if submission has grade
    public function getIsGradedAttribute()
    {
        return !is_null($this->grade);
    }
}