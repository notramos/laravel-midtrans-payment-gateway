<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderStatusUpdated;

class CustomerNotficationController extends Controller
{
    // Mengambil notifikasi
    public function index()
    {
        $notifications = Order::where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'pesanan diproses', 'pesanan selesai'])
            ->where(function($query) {
                $query->whereNull('last_viewed_at')
                      ->orWhereColumn('last_notified_at', '>', 'last_viewed_at');
            })
            ->latest()
            ->take(10)
            ->get(['id', 'order_number', 'status', 'created_at', 'last_notified_at', 'last_viewed_at']);

        return response()->json($notifications);
    }

    // Menandai notifikasi sebagai dilihat
    public function markAsViewed(Order $order)
    {
        try {
        $order->update(['last_viewed_at' => now()]);
        
        return response()->json([
            'success' => true,
            'redirect_url' => route('orders.show', $order->id),
            'message' => 'Notifikasi ditandai sebagai telah dilihat'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui status notifikasi'
        ], 500);
    }
    }

    // Menghitung jumlah notifikasi belum dilihat
    public function unreadCount()
    {
        $count = Order::where('user_id', AUTH::id())
            ->whereIn('status', ['paid', 'pesanan diproses', 'pesanan selesai'])
            ->where(function($query) {
                $query->whereNull('last_viewed_at')
                      ->orWhereColumn('last_notified_at', '>', 'last_viewed_at');
            })
            ->count();

        return response()->json(['count' => $count]);
    }
    public function update(Request $request, Order $order)
    {
        $previousStatus = $order->status;
        
        $validatedData = $request->validate([
            'status' => 'required|in:menunggu,paid,diproses,selesai,dibatalkan'
        ]);
        
        $order->update($validatedData);
        
        // Trigger event jika status berubah
        if ($order->wasChanged('status')) {
            event(new OrderStatusUpdated($order, $previousStatus));
        }
        
        return redirect()->route('orders.show', $order);
    }
    
}
