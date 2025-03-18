<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('customer_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data alamat
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            // 'status' => 'required|string|max:255',
        ]);

        // dd($request->status);


        $cartItems = Cart::where('customer_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }


        // Mulai transaksi database
        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => Auth::id(),
                'sub_total_price' => $cartItems->sum('total'),
                'tax' => $cartItems->sum('total') * 0.0093,
                'order_date' => now(),
                'total_price' => $cartItems->sum('total') + ($cartItems->sum('total') * 0.0093),

            ]);

            Address::create([
                'order_id' => $order->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            Cart::where('customer_id', Auth::id())->delete();

            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => uniqid('order_'),
                    'gross_amount' => (int) $order->total_price,
                ],
                'finish_redirect_url' => route('customer.order.index'),
                'return_url' => route('customer.order.index'),
            ];

            $snapToken = Snap::getSnapToken($params);
            session(['snap_token' => $snapToken]);

            DB::commit();

            return redirect()->route('customer.order.index')->with('success', 'Order placed successfully, proceed to payment.');
            // return redirect()->route('payment.page')->with('success', 'Order placed successfully, please proceed to payment.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $order = Order::with('items.product')->where('id', $id)->where('customer_id', Auth::id())->firstOrFail();
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
