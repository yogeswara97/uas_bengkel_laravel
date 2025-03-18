<x-layout class="mx-auto max-w-6xl py-6 sm:px-6 lg:px-10">
    <x-slot:title>Order Details</x-slot:title>

    <section class="mx-auto px-4 py-6 text-white">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold">Order #{{ $order->id }}</h1>
            <h1 class="text-2xl text-gray-400">{{ $order->created_at->format('M d, Y') }}</h1>
        </div>
        <hr class="border-gray-700 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
            <div class="">
                <div class="flex flex-col gap-4">
                    @foreach ($order->items as $item)
                        <a href="{{ route('customer.product.show', $item->product->slug) }}">
                            <div
                                class="flex items-center gap-4 p-4 bg-gray-800 rounded-lg shadow-lg hover:scale-95 hover:shadow-lg transition-all duration-500 ">
                                <img src="{{ asset('asset/images/products/' . $item->product->images[0]) }}"
                                    alt="Product Image" class="w-24 h-24 object-cover rounded-lg">
                                <div class="flex-grow">
                                    <h2 class="text-xl">{{ $item->product->name }}</h2>
                                    <p>Quantity: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-xl">${{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-4">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->sub_total_price, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span>Tax (0.93%)</span>
                        <span>${{ number_format($order->sub_total_price * 0.0093, 2) }}</span>
                    </div>
                    <hr class="border-gray-700 my-4">
                    <div class="flex font-bold justify-between mb-4">
                        <span>Total</span>
                        <span>${{ number_format($order->sub_total_price + $order->sub_total_price * 0.0093, 2) }}</span>
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between text-xl">
                        <span>Status</span>
                        <span
                            class="p-2 px-4 font-bold rounded-lg shadow-lg text-center text-sm uppercase flex items-center tracking-wide justify-center
                            @if ($order->status == 'pending') bg-orange-500 text-white
                            @elseif($order->status == 'completed') bg-green-500 text-white
                            @elseif($order->status == 'proccessing') bg-slate-500 text-white
                            @else bg-red-500 text-white @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-200 border-b-2 border-gray-700 pb-2">Shipping
                        Address</h2>
                    <div class="flex flex-col gap-3 mt-4">
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            <p class="text-lg font-medium text-white">{{ $order->address->full_name }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <p class="text-md text-gray-300">{{ $order->address->street_address }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <i class="fas fa-city"></i>
                            </span>
                            <p class="text-md text-gray-300">{{ $order->address->city }},
                                {{ $order->address->zip_code }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <i class="fas fa-map"></i>
                            </span>
                            <p class="text-md text-gray-300">{{ $order->address->state }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">
                                <i class="fas fa-phone"></i>
                            </span>
                            <p class="text-md text-gray-300">{{ $order->address->phone }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layout>
