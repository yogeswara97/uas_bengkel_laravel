<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $selectedYear = $request->query('year', Carbon::now()->year);

        $todayOrdersCount = Order::whereDate('created_at', now()->toDateString())->count();
        $todayRevenue = Order::whereDate('created_at', now()->toDateString())->sum('total_price');
        $thisMonthOrdersCount = Order::whereMonth('created_at', now()->month)->count();
        $thisMonthRevenue = Order::whereMonth('created_at', now()->month)->sum('total_price');
        $outOfStock = Product::where('stock', 0)->count();

        $popularProducts = Product::withCount(['items as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"));
        }])
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $ordersData = [];
        for ($i = 1; $i <= 12; $i++) {
            $ordersData[$i] = $monthlyRevenue->get($i, 0);
        }

        $years = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.index', [
            'todayOrdersCount' => $todayOrdersCount,
            'todayRevenue' => $todayRevenue,
            'thisMonthOrdersCount' => $thisMonthOrdersCount,
            'thisMonthRevenue' => $thisMonthRevenue,
            'outOfStock' => $outOfStock,
            'ordersData' => array_values($ordersData),
            'popularProducts' => $popularProducts,
            'years' => $years,
            'selectedYear' => $selectedYear
        ]);
    }
}
