<x-layout class="mx-auto max-w-6xl py-6 sm:px-6 lg:px-10">
    <x-slot:title>Order Details - Order #{{ $order->id }}</x-slot:title>

    <section class="mx-auto px-4 py-6 text-white">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold">Order #{{ $order->id }}</h1>
            <h1 class="text-2xl text-gray-400">{{ $order->created_at->format('M d, Y') }}</h1>
        </div>
        <hr class="border-gray-700 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-2">
                <div class="flex flex-col gap-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-800 rounded-lg shadow-lg">
                            <img src="{{ asset('asset/images/products/' . $item->product->images[0]) }}"
                                alt="Product Image" class="w-24 h-24 object-cover rounded-lg">
                            <div class="flex-grow">
                                <h2 class="text-xl">{{ $item->product->name }}</h2>
                                <p>Quantity: {{ $item->quantity }}</p>
                            </div>
                            <p class="text-xl">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
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
                    <h2 class="text-2xl font-semibold mb-4">Shipping Address</h2>
                    <div class="flex flex-col gap-2">
                        <p class="text-xl font-medium">{{ $order->address->full_name }}</p>
                        <p class="text-md">{{ $order->address->street_address }}</p>
                        <p class="text-md">{{ $order->address->city }}, {{ $order->address->zip_code }}</p>
                        <p class="text-md">{{ $order->address->state }}</p>
                        <p class="text-md">{{ $order->address->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
