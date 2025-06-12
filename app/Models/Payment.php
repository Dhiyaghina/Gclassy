<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'class_room_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_proof',
        'status',
        'notes',
        'approved_at',
        'approved_by',
        'rejected_at'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];
    
    /**
     * Relationship to student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    /**
     * Relationship to class room
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    
    /**
     * Relationship to approver (admin user)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Check if payment is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Check if payment is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
