<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CustomerService;

class NotificationService
{
    public function get()
    {
        $orderCount = Order::where('status', 'menunggu')->count();
        $chatCount  = CustomerService::where('status', 'pending')
                         ->distinct('user_id')
                         ->count('user_id');

        return [
            [
                'type' => 'order',
                'title' => 'Pesanan',
                'message' => "Ada {$orderCount} pesanan masuk",
                'icon' => 'shopping-bag',
                'color' => 'blue',
                'count' => $orderCount,
                'url' => route('admin.order.index')
            ],
            [
                'type' => 'chat',
                'title' => 'Chat',
                'message' => "Ada {$chatCount} pesan dari pelanggan",
                'icon' => 'message-circle',
                'color' => 'green',
                'count' => $chatCount,
                'url' => route('admin.customer-service.index')
            ]
        ];
    }
}
