<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'design_notes' => 'required|string|min:20',
            'design_file' => 'required|file|max:10240|mimes:jpeg,jpg,png,pdf,ai,psd',
            'panjang' => 'nullable|numeric|min:0.1',
            'lebar' => 'nullable|numeric|min:0.1',
        ]);

        try {
            $user = Auth::user();
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            // Store design file
            $filePath = $request->file('design_file')->store('designs', 'public');
            $data = [
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'design_notes' => $validated['design_notes'],
                'design_file' => $filePath,
            ];
            if (isset($validated['panjang']) && isset($validated['lebar'])) {
                $data['panjang'] = $validated['panjang'];
                $data['lebar'] = $validated['lebar'];
            }
            CartItem::create($data);
            return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $cart = Cart::with('cartItems')->where('user_id', Auth::id())->first();

        $total = optional($cart)->cartItems?->sum(function ($item) {
            $isUkuranBased = in_array($item->product->name, ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker (Branding)']);

            return $isUkuranBased
                ? $item->product->price * $item->quantity * $item->panjang * $item->lebar
                : $item->product->price * $item->quantity;
        }) ?? 0;

        return view('page.cart', compact('cart', 'total'));
    }

    /**
     * Update item quantity via AJAX
     */
    public function updateQuantity(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:cart_items,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = CartItem::with(['cart', 'product'])->find($request->item_id);

            if (!$cartItem || $cartItem->cart->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan atau tidak memiliki akses.'
                ], 403);
            }

            // Update quantity
            $cartItem->update(['quantity' => $request->quantity]);

            // Hitung subtotal dengan panjang x lebar jika produk berbasis ukuran
            $isUkuranBased = in_array($cartItem->product->name, ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker (Branding)']);
            $subtotal = $isUkuranBased
                ? $cartItem->product->price * $cartItem->quantity * $cartItem->panjang * $cartItem->lebar
                : $cartItem->product->price * $cartItem->quantity;

            // Hitung ulang total
            $total = $this->calculateCartTotal($cartItem->cart);

            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk diperbarui.',
                'subtotal' => $subtotal,
                'total' => $total,
                'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'item_price_formatted' => 'Rp ' . number_format($cartItem->product->price, 0, ',', '.'),
                'item_subtotal_formatted' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                'total_items' => $cartItem->cart->cartItems->sum('quantity'),
                'is_ukuran_based' => $cartItem->product->isUkuranBased(),
                'panjang' => $cartItem->panjang,
                'lebar' => $cartItem->lebar
            ]);
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui quantity.'
            ], 500);
        }
    }

    /**
     * Remove item from cart via AJAX
     */
    public function removeItem(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:cart_items,id'
            ]);

            $cartItem = CartItem::with('cart')->find($request->item_id);

            if (!$cartItem || $cartItem->cart->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan atau tidak memiliki akses.'
                ], 403);
            }

            $cart = $cartItem->cart;
            $cartItem->delete();

            // Recalculate total
            $total = $this->calculateCartTotal($cart);
            $totalItems = $cart->cartItems()->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang.',
                'total' => $total,
                'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'total_items' => $totalItems,
                'is_empty' => $totalItems == 0
            ]);
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus item.'
            ], 500);
        }
    }

    /**
     * Clear entire cart via AJAX
     */
    public function clearCart(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi.'
                ], 401);
            }

            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                $cart->cartItems()->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Keranjang berhasil dikosongkan.',
                    'redirect' => route('cart.index')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Keranjang tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengosongkan keranjang.'
            ], 500);
        }
    }

    /**
     * Process checkout
     */
    public function checkout(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu.',
                'redirect' => route('login')
            ], 401);
        }

        $user = Auth::user();
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

        // Check if cart exists and has items
        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong.',
                'redirect' => route('cart.index')
            ], 400);
        }

        $total = $this->calculateCartTotal($cart);

        // Check if total is valid
        if ($total <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total pembayaran tidak valid.'
            ], 400);
        }

        try {

            DB::beginTransaction();

            // Generate unique order number
            do {
                $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8));
            } while (Order::where('order_number', $orderNumber)->exists());

            $total = $cart->cartItems->sum(function ($item) {
                $product = $item->product;
                $isUkuranBased = $product->isUkuranBased();
                $panjang = $item->panjang ?? 1;
                $lebar = $item->lebar ?? 1;

                return $isUkuranBased
                    ? $product->price * $item->quantity * $panjang * $lebar
                    : $product->price * $item->quantity;
            });


            // Create new order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'belum dibayar',
                'shipping_address' => $user->address,
                'phone_number' => $user->phone,
            ]);

            // Add order items
            foreach ($cart->cartItems as $item) {
                $product = $item->product;
                $isUkuranBased = $product->isUkuranBased();
                $panjang = $item->panjang ?? 1;
                $lebar = $item->lebar ?? 1;

                $subtotal = $isUkuranBased
                    ? $product->price * $item->quantity * $panjang * $lebar
                    : $product->price * $item->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                    'design_notes' => $item->design_notes,
                    'design_file' => $item->design_file,
                    'panjang' => $isUkuranBased ? $panjang : null,
                    'lebar' => $isUkuranBased ? $lebar : null,
                ]);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_type' => 'midtrans',
                'status' => 'pending',
                'amount' => $total,
                'created_at' => now(),
            ]);

            // Clear cart after successful order creation
            $cart->cartItems()->delete();
            $cart->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat! Silakan lanjutkan pembayaran.',
                'redirect' => route('payments.show', $orderNumber)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cart_id' => $cart->id ?? null,
                'total' => $total ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Calculate total for a cart
     */
    private function calculateCartTotal(Cart $cart)
    {
        return $cart->cartItems->sum(function ($item) {
            $isUkuranBased = in_array($item->product->name, ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker (Branding)']);

            return $isUkuranBased
                ? $item->product->price * $item->quantity * $item->panjang * $item->lebar
                : $item->product->price * $item->quantity;
        });
    }

    /**
     * Get cart data for API
     */
    public function getCartData()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi.'
            ], 401);
        }

        $cart = Cart::with(['cartItems' => function ($query) {
            $query->with('product');
        }])->where('user_id', $user->id)->first();

        $total = 0;
        $totalItems = 0;

        if ($cart && $cart->cartItems) {
            $total = $this->calculateCartTotal($cart);
            $totalItems = $cart->cartItems->sum('quantity');
        }

        return response()->json([
            'success' => true,
            'total' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
            'total_items' => $totalItems,
            'is_empty' => $totalItems == 0
        ]);
    }
}
