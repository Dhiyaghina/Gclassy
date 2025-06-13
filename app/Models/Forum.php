<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $table = 'forum';
    protected $fillable = [
        'class_room_id',
        'user_id',
        'content',
        'attachment'
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }
}