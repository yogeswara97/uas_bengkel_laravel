<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.invoice', compact('order'));
    }
}
