<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function index()
    {
        $title = 'Product';
        $categories = Category::with(['product' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        return view('product', compact('title', 'categories'));
    }

    public function show(Product $product)
    {

        $recommendedProducts = Product::whereHas('category', function ($query) use ($product) {
            $query->where('categories.id', $product->category_id);
        })
        ->withCount('items')
        ->orderBy('items_count', 'desc')
        ->where('stock','>',0)
        ->take(4)
        ->get();

        return view('detail-product', [
            'title' => 'Product | '. $product->name,
            'product' => $product,
            'recommendedProducts' => $recommendedProducts
        ]);
    }
}
