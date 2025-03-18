<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function checkout()
    {
        $title = 'Checkout';

        $itemCarts = Cart::with(['customer', 'product'])->where('customer_id', Auth::id())->get();
        $totalAmount = $itemCarts->sum('total');

        return view('checkout', compact('title', 'itemCarts'));
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Cart';
        $itemCarts = Cart::with(['customer', 'product'])->where('customer_id', Auth::id())->get();
        return view('cart', compact('title', 'itemCarts'));
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
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer',
                'total' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            // Lakukan sesuatu jika validasi gagal, misalnya mengembalikan respons dengan pesan error
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        Cart::updateOrCreate(
            [
                'customer_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity,
                'total' => $request->total
            ]
        );

        $product = Product::find($request->product_id);

        return redirect()->route('customer.product.show', ['product' => $product->slug])->with('success', 'Product added to cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->quantity = $request->input('quantity');
            $cartItem->total = $cartItem->quantity * $cartItem->product->price;
            $cartItem->save();

            return redirect()->route('cart.index');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Cart::where('id', $id)->where('customer_id', Auth::id())->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart');
        }
    }
}
