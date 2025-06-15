<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika berbeda dari plural 'tasks'
    protected $table = 'tasks';

    // Menentukan atribut yang dapat diisi massal
    protected $fillable = [
        'class_room_id',
        'title',
        'content',
        'attachment',
    ];

    /**
     * Relasi ke kelas (ClassRoom).
     * Setiap tugas milik satu kelas.
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * Relasi ke user (guru) yang membuat tugas ini.
     * Anggap ada relasi 'user_id' di database jika dibutuhkan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Jika ada file attachment, pastikan file tersimpan dengan benar.
     * @return string
     */
    public function getAttachmentUrl()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    
}
