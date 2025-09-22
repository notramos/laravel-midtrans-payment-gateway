<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderAdminController extends Controller
{
    // OrderController.php
    public function index()
    {
        return view('admin.orderindex');
    }
     public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        
        return view('admin.order', compact('order'));
    }
      public function getOrdersData()
    {
        try {
            // Mengambil semua pesanan dengan relasi user
            $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
            
            // Mengelompokkan pesanan berdasarkan status
            $groupedOrders = [
                'belum dibayar' => $orders->where('status', 'belum dibayar')->values(),
                'menunggu konfirmasi' => $orders->where('status', 'menunggu konfirmasi')->values(),
                'pesanan diproses' => $orders->where('status', 'pesanan diproses')->values(),
                'pesanan selesai' => $orders->where('status', 'pesanan selesai')->values()
            ];

            // Menghitung jumlah per status
            $counts = [
                'belum_dibayar' => $orders->where('status', 'belum dibayar')->count(),
                'menunggu_konfirmasi' => $orders->where('status', 'menunggu konfirmasi')->count(),
                'sedang_diproses' => $orders->where('status', 'pesanan diproses')->count(),
                'selesai' => $orders->where('status', 'pesanan selesai')->count()
            ];

            return response()->json([
                'success' => true,
                'orders' => $groupedOrders,
                'counts' => $counts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

      public function updateStatusIndex(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:belum dibayar,menunggu konfirmasi,pesanan diproses,pesanan selesai'
            ]);

            $order = Order::findOrFail($id);
            $oldStatus = $order->status;
            
            $order->update([
                'status' => $request->status,
                'is_read' => true
            ]);

            // Log aktivitas atau kirim notifikasi jika diperlukan

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'order' => $order->load('user')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {   
        $request->validate([
            'status' => 'required|in:pending,pesanan diproses,pesanan selesai,selesai,dibatalkan'
        ]);
        $order->update([
            'status' => $request->status,
            'is_read' => false // Reset read status when status changes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->status
        ]);
    }
}

