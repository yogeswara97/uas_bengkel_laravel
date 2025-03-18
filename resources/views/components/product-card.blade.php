<a href="{{ route('customer.product.show',$product->slug) }}"
    class="relative bg-slate-700 rounded-lg overflow-hidden shadow-md hover:scale-95 hover:shadow-lg transition-all duration-500 group @if ($product->stock <= 0) opacity-50 cursor-not-allowed @endif"
    @if ($product->stock <= 0) onclick="return false;" @endif>
    @if (!empty($product->images) && isset($product->images[0]))
        <img class="w-full h-40 md:h-80 lg:h-96 object-cover group-hover:scale-[1.05] transition-all duration-500"
            src="{{ asset('asset/images/products/' . $product->images[0]) }}"
            alt="{{ $product->name }}">
    @else
        <img class="w-full h-40 md:h-96 object-cover"
            src="{{ asset('default-image-url.jpg') }}"
            alt="{{ $product->name }}">
    @endif
    <div class="p-4">
        <h3 class="text-sm md:text-xl font-semibold">{{ $product->name }}</h3>
        <p class="mt-2 text-sm md:text-xl text-gray-400">${{ $product->price }}</p>
    </div>
    @if ($product->stock <= 0)
        <div class="absolute inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center text-white font-bold text-lg">Out of Stock</div>
    @endif
</a>


