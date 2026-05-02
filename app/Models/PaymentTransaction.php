<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'reference',
        'merchant_order_id',
        'payment_method',
        'payment_name',
        'amount',
        'fee',
        'status',
        // 'payment_url',
        'callback_data',
        'expired_time'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'expired_time' => 'datetime',
        'callback_data' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'dibatalkan');
    }
}