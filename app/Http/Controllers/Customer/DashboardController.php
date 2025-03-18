<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $bestSellerProducts = Product::withSum('items as total_quantity_sold', 'quantity')
        ->orderByDesc('total_quantity_sold')
        ->where('stock','>',0)
        ->where('on_sale',true)
        ->limit(4)
        ->get();

        $indexDashboard = Product::orderBy('created_at', 'desc')->first();

        return view('index', [
            "title" => 'Home Page',
            'bestSeller' => $bestSellerProducts,
            'indexDashboard' => $indexDashboard
        ]);
    }
}
