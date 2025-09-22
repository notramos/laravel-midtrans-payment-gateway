<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Payment;

class MidtransWebhookController extends Controller
{
    public function handleMidtransNotification(Request $request)
    {
        Log::info('Midtrans notification received', ['data' => $request->all()]);
        Log::info('Received Midtrans Notification', ['order_id' => $request->order_id]);
        
        try {
            $notificationBody = $request->all();
            
            // Configure Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            
            // Verify notification signature
            $notificationJson = json_encode($notificationBody);
            $signature = hash('sha512', $notificationBody['order_id'] . $notificationBody['status_code'] . $notificationBody['gross_amount'] . config('midtrans.server_key'));
            
            if ($signature !== $notificationBody['signature_key']) {
                Log::error('Invalid signature', ['received' => $notificationBody['signature_key'], 'calculated' => $signature]);
                return response('Invalid signature', 403);
            }
            
            // Process the notification
            $orderId = $notificationBody['order_id'];
            $transactionStatus = $notificationBody['transaction_status'];
            $fraudStatus = $notificationBody['fraud_status'] ?? null;
            $transactionId = $notificationBody['transaction_id'];
            
            // Get order from database
            $order = Order::where('order_number', $orderId)->first();
            
            if (!$order) {
                Log::error('Order not found', ['order_id' => $orderId]);
                return response('Order not found', 404);
            }
            
            // Create or update payment record
            $payment = Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $transactionId,
                    'amount' => $notificationBody['gross_amount'],
                    'payment_type' => $notificationBody['payment_type'],
                    'transaction_time' => $notificationBody['transaction_time'],
                    'status' => $transactionStatus,
                    'payment_details' => json_encode($notificationBody)
                ]
            );
            
            // Update order status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $order->status = 'paid';
                }
            } else if ($transactionStatus == 'settlement') {
                $order->status = 'paid';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $order->status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $order->status = 'pending';
            }
            
            $order->save();
            
            Log::info('Order status updated', ['order_id' => $orderId, 'status' => $order->status]);
            
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Error handling Midtrans notification: ' . $e->getMessage());
            return response('Error', 500);
        }
    }
}
