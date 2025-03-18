<x-layout class="mx-auto py-2 max-w-full sm:px-6 lg:px-10">
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container mx-auto px-4 py-6">
        @foreach ($categories as $category)
            @php
                $onSaleProducts = $category->product->filter(function($item) {
                    return $item->on_sale;
                });
            @endphp

            @if ($onSaleProducts->isNotEmpty())
                <h1 class="text-3xl font-bold mb-6">{{ $category->name }}</h1>
                <div class="product-grid">
                    @foreach ($onSaleProducts as $product)
                        <x-product-card :product="$product"/>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</x-layout>
