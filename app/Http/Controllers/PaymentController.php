<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use FFI\Exception;

class PaymentController extends Controller
{
     public function index($orderNumber)
    {
        try {
            // Find order by order number
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Determine payment status
            $paymentStatus = null;
            if ($order->status === 'menunggu konfirmasi') {
                $paymentStatus = 'success';
            } elseif ($order->status === 'expired') {
                $paymentStatus = 'expired';
            }
            
            return view('page.payment', compact('order', 'orderNumber', 'paymentStatus'));
            
        } catch (\Exception $e) {
            return view('page.payment', [
                'errorMessage' => 'Pesanan tidak ditemukan.',
                'orderNumber' => $orderNumber
            ]);
        }
    }

    public function initPayment(Request $request)
    {
        try {
            $orderNumber = $request->input('order_number');
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Check if order is already paid
            if ($order->status === 'menunggu konfirmasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan sudah dibayar',
                    'redirect' => route('payment.index', $orderNumber)
                ]);
            }

            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Use existing Snap Token if available
            if ($order->snap_token) {
                $snapToken = $order->snap_token;
            } else {
                // Prepare payment parameters
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => $order->total_amount,
                    ],
                    'customer_details' => [
                        'first_name' => $order->user->name,
                        'email' => $order->user->email,
                    ],
                ];

                // Get new Snap Token
                $snapToken = Snap::getSnapToken($params);

                // Save Snap Token to database
                $order->update(['snap_token' => $snapToken]);
            }

            return response()->json([
                'success' => true,
                'snapToken' => $snapToken
            ]);

        } catch (Exception $e) {
            Log::error('Midtrans Payment Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran.'
            ]);
        }
    }

    public function handlePaymentResult(Request $request)
    {
        try {
            $paymentResult = $request->input('result');
            $paymentData = json_decode($paymentResult, true);
            
            // Log the full payment result for debugging
            Log::info('Midtrans Payment Result', $paymentData);

            // Find order
            $order = Order::where('order_number', $paymentData['order_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                Log::error('Order not found', ['order_id' => $paymentData['order_id']]);
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ]);
            }

            // Handle expired payment
            if (isset($paymentData['status_code']) && $paymentData['status_code'] == 407) {
                Log::warning('Pembayaran expired', ['order_id' => $order->order_number]);
                
                $order->update(['status' => 'expired']);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran telah kadaluarsa. Silakan coba bayar ulang.',
                    'status' => 'expired'
                ]);
            }

            // Find or create payment record
            $payment = $order->payment ?? new Payment();

            // Prepare payment details
            $paymentDbData = [
                'order_id' => $order->id,
                'payment_type' => $paymentData['payment_type'],
                'transaction_id' => $paymentData['transaction_id'] ?? null,
                'amount' => $order->total_amount,
                'payment_details' => json_encode($paymentData)
            ];

            // Determine status based on transaction status
            $transactionStatus = $paymentData['transaction_status'] ?? null;
            
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    $order->status = 'menunggu konfirmasi';
                    $paymentDbData['status'] = 'success';
                    $responseStatus = 'success';
                    break;
                
                case 'pending':
                    $order->status = 'pending';
                    $paymentDbData['status'] = 'pending';
                    $responseStatus = 'pending';
                    break;
                
                case 'expire':
                    $order->status = 'expired';
                    $paymentDbData['status'] = 'failed';
                    $responseStatus = 'expired';
                    break;

                case 'deny':
                case 'cancel':
                    $order->status = 'failed';
                    $paymentDbData['status'] = 'failed';
                    $responseStatus = 'failed';
                    break;
                
                default:
                    Log::warning('Unhandled transaction status', [
                        'status' => $transactionStatus,
                        'full_result' => $paymentData
                    ]);
                    $paymentDbData['status'] = 'pending';
                    $responseStatus = 'pending';
            }

            // Update or create payment record
            $payment->fill($paymentDbData);
            $payment->save();

            // Save order status
            $order->save();

            return response()->json([
                'success' => true,
                'status' => $responseStatus,
                'message' => 'Pembayaran berhasil diproses'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Result Handling Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran.'
            ]);
        }
    }

    public function retryPayment($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Reset snap token to force new payment
            $order->update(['snap_token' => null]);

            return redirect()->route('payment.index', $orderNumber)
                ->with('success', 'Silakan coba bayar ulang.');

        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }
    }   
}
