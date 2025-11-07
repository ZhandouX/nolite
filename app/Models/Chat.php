<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    /**
     * Relasi ke user (pengguna yang melakukan chat)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke admin (opsional, jika chat dikelola oleh admin tertentu)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Relasi ke semua pesan dalam chat
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Ambil pesan terakhir (untuk daftar chat)
     * Digunakan di AdminChatController@index()
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Cek apakah ada pesan belum dibaca oleh admin
     */
    public function hasUnreadMessages()
    {
        return $this->messages()
            ->where('is_read', false)
            ->whereNotNull('sender_id')
            ->exists();
    }
}
