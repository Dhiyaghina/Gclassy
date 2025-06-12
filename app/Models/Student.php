<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'student_id',
        'date_of_birth',
        'address'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date'
    ];
    
    /**
     * Relationship to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relationship to classes (many-to-many)
     */
    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_student')->withTimestamps();
    }
    
    /**
     * Relationship to payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
