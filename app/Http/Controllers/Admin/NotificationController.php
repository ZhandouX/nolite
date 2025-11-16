<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CustomerService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function notifications(): JsonResponse
    {
        // Hitung jumlah pesanan menunggu
        $orderCount = Order::where('status', 'menunggu')->count();

        // Hitung jumlah user yang memiliki chat pending
        $chatCount = CustomerService::where('status', 'pending')
                    ->distinct('user_id')
                    ->count('user_id');

        return response()->json([
            'status' => 'success',
            'notifications' => [
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
            ]
        ]);
    }
}
