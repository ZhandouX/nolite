<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Events\NotificationUpdated;
use App\Models\Order;
use App\Models\CustomerService;

class NotificationController extends Controller
{
    public function notifications(): JsonResponse
    {
        $data = app(\App\Services\NotificationService::class)->get();

        return response()->json(['status' => 'success', 'notifications' => $data]);
    }

    public function all()
    {
        // Ambil semua order menunggu
        $order = Order::where('status', 'menunggu')
            ->with('user', 'items')
            ->get()
            ->map(function ($o) {
                return [
                    'id'       => $o->id,
                    'customer' => $o->user->name ?? 'Pengguna',
                    'items'    => $o->items->map(function ($i) {
                        return [
                            'name' => $i->nama_produk,
                            'qty'  => $i->jumlah,
                        ];
                    }),
                    'url' => route('admin.order.show', $o->id),
                ];
            });

        // Ambil chat pending
        $chat = CustomerService::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($c) {
                return [
                    'id'      => $c->id,
                    'name'    => $c->user->name ?? 'Unknown',
                    'message' => $c->message,
                    'url'     => route('admin.customer-service.show', $c->id),
                ];
            });

        return response()->json([
            'order' => $order,
            'chat'  => $chat,
        ]);
    }
}
