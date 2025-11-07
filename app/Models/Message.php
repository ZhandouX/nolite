<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke chat induk
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Relasi ke pengirim pesan (bisa user atau admin)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Helper untuk cek apakah pesan ini dikirim oleh admin
     */
    public function isFromAdmin()
    {
        return $this->sender && $this->sender->role === 'admin';
    }

    /**
     * Helper untuk cek apakah pesan ini dikirim oleh user
     */
    public function isFromUser()
    {
        return $this->sender && $this->sender->role === 'user';
    }
}
