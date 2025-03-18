<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function indexCustomer()
    {
        $title = 'Product';
        $categories = Category::with(['product' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        return view('product', compact('title', 'categories'));
    }

    public function showCustomer(Product $product)
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        $outOfStocks = Product::where('stock', 0)->get();
        $countOutOfStocks = Product::where('stock', 0)->count();
        return view('admin.products', compact('products', 'categories', 'outOfStocks', 'countOutOfStocks'));
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
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,avif'
        ]);

        $imageNames = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            if (count($images) > 5) {
                return redirect()->back()->withErrors(["images" => "You can only upload up to 5 images"]);
            }

            foreach ($images as $image) {
                $originalName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $timeStamp = time();
                $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $timeStamp . '.' . $extension;

                $publicPath = public_path('asset/images/products/');

                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }

                $image->move($publicPath, $imageName);
                $imageNames[] = $imageName;
            }
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => strtolower($request->description),
            'images' => json_encode($imageNames, JSON_UNESCAPED_SLASHES),
            'on_sale' => $request->has('on_sale')
        ]);

        return redirect()->route('products.index')->with('success', 'Product Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'existing_images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,avif|max:2048'
        ]);

        $existingImages = $request->existing_images ?? [];
        $imageNames = $product->images ?? [];

        // Delete images that are not selected to be kept
        $imagesToDelete = array_diff($imageNames, $existingImages);
        foreach ($imagesToDelete as $image) {
            $publicPath = public_path('asset/images/products/' . $image);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }

        // Filter out images that were deleted
        $imageNames = array_intersect($imageNames, $existingImages);

        // Check total image count
        $totalImages = count($imageNames) + ($request->hasFile('images') ? count($request->file('images')) : 0);
        if ($totalImages > 5) {
            return redirect()->back()->withErrors(["images" => "You can only have up to 5 images in total"]);
        }

        // Add new images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $originalName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $timestamp = time();
                $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

                $publicPath = public_path('asset/images/products/');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                $image->move($publicPath, $imageName);
                $imageNames[] = $imageName;
            }
        }

        // $slug = Str::slug($request->name);
        // $originalSlug = $slug;
        // $count = 1;

        // while (Product::where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $count++;
        // }

        $product->update([
            'name' => $request->name,
            // 'slug' => $slug,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'images' => json_encode($imageNames, JSON_UNESCAPED_SLASHES),
            'on_sale' => $request->has('on_sale')
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $imagePaths = $product->images;

        if (is_array($imagePaths)) {
            foreach ($imagePaths as $image) {
                $publicPath = public_path('asset/images/products/' . $image);
                if (file_exists($publicPath)) {
                    unlink($publicPath);
                }
            }
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product delete successfully');
    }
}
