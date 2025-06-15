<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

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
