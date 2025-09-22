<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class NotificationController extends Controller
{
      public function index()
    {
        $orders = Order::where('status', 'menunggu konfirmasi')
                ->where('is_read', false)
                ->latest()
                ->take(10)
                ->get(['id', 'order_number', 'total_amount', 'shipping_address', 'phone_number']);

    return response()->json($orders);
    }
    public function markAsRead($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['is_read' => true]);

        return response()->json(['message' => 'Pesanan ditandai sebagai dibaca']);
    }
}
