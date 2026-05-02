<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'two_factor_secret',
        'two_factor_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'password'           => 'hashed',
            'two_factor_enabled' => 'boolean',
        ];
    }

    // ✅ Helper cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Relasi ke chat milik user (1 user = 1 chat)
     */
    public function chat()
    {
        return $this->hasOne(Chat::class, 'user_id');
    }

    /**
     * Relasi ke chat yang dikelola admin
     */
    public function adminChats()
    {
        return $this->hasMany(Chat::class, 'admin_id');
    }

    /**
     * Relasi ke semua pesan yang dikirim user/admin ini
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
