<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

     public function getOrderStats()
    {
       $now = now();
    $thisMonthCount = \App\Models\Order::whereYear('created_at', $now->year)
        ->whereMonth('created_at', $now->month)
        ->count();

    $lastMonth = $now->copy()->subMonth();
    $lastMonthCount = \App\Models\Order::whereYear('created_at', $lastMonth->year)
        ->whereMonth('created_at', $lastMonth->month)
        ->count();

    $percentageChange = 0;

    if ($lastMonthCount > 0) {
        $percentageChange = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
    } elseif ($thisMonthCount > 0) {
        $percentageChange = 100;
    }

    return response()->json([
        'total_orders' => $thisMonthCount,
        'percentage_change' => round($percentageChange, 2),
    ]);
    }

    public function getRevenueStats()
    {
        $now = now();

        $thisMonthRevenue = \App\Models\Payment::where('status', 'success')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('amount');

        $lastMonth = $now->copy()->subMonth();

        $lastMonthRevenue = \App\Models\Payment::where('status', 'success')
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->sum('amount');

        $percentageChange = 0;

        if ($lastMonthRevenue > 0) {
            $percentageChange = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($thisMonthRevenue > 0) {
            $percentageChange = 100;
        }

        return response()->json([
            'revenue' => $thisMonthRevenue,
            'percentage_change' => round($percentageChange, 2),
        ]);
    }
    public function getNewOrderStats()
    {
        $now = now();
        $thisWeek = $now->startOfWeek();
        $lastWeek = $thisWeek->copy()->subWeek();

        $thisWeekCount = \App\Models\Order::where('created_at', '>=', $thisWeek)->count();

        $lastWeekCount = \App\Models\Order::whereBetween('created_at', [$lastWeek, $thisWeek])->count();

        $percentageChange = 0;

        if ($lastWeekCount > 0) {
            $percentageChange = (($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100;
        } elseif ($thisWeekCount > 0) {
            $percentageChange = 100;
        }

        return response()->json([
            'new_orders' => $thisWeekCount,
            'percentage_change' => round($percentageChange, 2),
        ]);
    }
    public function getNewCustomerStats()
    {
        $now = now();
        $thisMonth = [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        $lastMonth = [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()];

        $thisMonthCount = \App\Models\User::whereBetween('created_at', $thisMonth)->count();
        $lastMonthCount = \App\Models\User::whereBetween('created_at', $lastMonth)->count();

        $percentageChange = 0;

        if ($lastMonthCount > 0) {
            $percentageChange = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        } elseif ($thisMonthCount > 0) {
            $percentageChange = 100;
        }

        return response()->json([
            'new_customers' => $thisMonthCount,
            'percentage_change' => round($percentageChange, 2),
        ]);
    }

    public function getSalesChart(Request $request)
    {
        $days = (int) $request->query('days', 30);
        $startDate = now()->subDays($days);

        $sales = \App\Models\Payment::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $sales->pluck('date');
        $data = $sales->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }


    public function getPopularProducts(Request $request)
    {
        $days = (int) $request->query('days', 30);
        $startDate = now()->subDays($days);

        $data = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name as product', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->where('orders.created_at', '>=', $startDate)
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(6)
            ->get();

        return response()->json([
            'labels' => $data->pluck('product'),
            'data' => $data->pluck('total_sold'),
        ]);
    }

    public function getRecentOrdersData(Request $request)
    {
     $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'data' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => '#ORD-' . $order->id,
                    'customer_name' => $order->user->name,
                    'customer_email' => $order->user->email,
                    'product_list' => $order->orderItems->map(fn($item) => $item->product->name)->toArray(),
                    'date' => $order->created_at->translatedFormat('d M Y'),
                    'total' => number_format($order->total_amount, 0, ',', '.'),
                    'status' => ucfirst($order->status),
                    'status_class' => match ($order->status) {
                        'menunggu konfirmasi' => 'bg-yellow-100 text-yellow-800',
                        'pesanan selesai','paid' => 'bg-green-100 text-green-800',
                        default => 'bg-gray-100 text-gray-800',
                    }
                ];
            }),
        ]);
    }


}
