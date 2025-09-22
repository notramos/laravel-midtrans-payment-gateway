<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('page.indexOrder', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized access to this order.');
        }
        // Load relasi yang diperlukan
        $order->load(['orderItems.product', 'payment']);

        return view('page.order', compact('order'));
    }

    public function getStatuses()
    {
        $orders = Order::where('user_id', Auth::id())
            ->select('id', 'status')
            ->get();

        return response()->json($orders);
    }
}
