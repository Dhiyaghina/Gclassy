<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'employee_id',
        'subject',
        'qualification',
        'experience',
        'bio'
    ];
    
    /**
     * Relationship to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relationship to classes
     */
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
