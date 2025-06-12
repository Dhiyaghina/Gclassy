<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'subject',
        'description',
        'type',
        'teacher_id',
        'schedule',
        'price',
        'enrollment_code',
        'is_active'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];
    
    /**
     * Relationship to teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    /**
     * Relationship to students (many-to-many)
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student')->withTimestamps();
    }
    
    /**
     * Relationship to payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    /**
     * Check if class is bimbel type
     */
    public function isBimbel()
    {
        return $this->type === 'bimbel';
    }
    
    /**
     * Get students count
     */
    public function getStudentsCountAttribute()
    {
        return $this->students()->count();
    }
    
    /**
     * Generate unique enrollment code for regular classes
     */
    public static function generateEnrollmentCode()
    {
        do {
            $code = strtoupper(substr(md5(time() . rand(1000, 9999)), 0, 8));
        } while (self::where('enrollment_code', $code)->exists());
        
        return $code;
    }
    
    /**
     * Check if class requires enrollment code
     */
    public function requiresEnrollmentCode()
    {
        return $this->type === 'reguler';
    }
}
