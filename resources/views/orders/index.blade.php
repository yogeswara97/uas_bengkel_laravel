<x-layout class="mx-auto max-w-6xl py-6 sm:px-6 lg:px-10">
    <x-slot:title>Orders</x-slot:title>

    <section class="container mx-auto px-4 py-6 text-white">
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-4xl mb-6 font-semibold">My Orders</h1>
        {{-- <hr class="block md:hidden bg-slate-600 opacity-40"> --}}

        @if ($orders->isEmpty())
            <div class="flex flex-col items-center w-full md:items-start py-5 px-9">
                <h1 class="text-xl mb-8">Your orders is Empty.</h1>
                <div class="flex gap-4 w-full md:w-96">
                    <a href="{{ route('customer.product.index') }}"
                        class="bg-slate-900 py-4 px-6 rounded-lg text-center w-full hover:scale-95 hover:bg-slate-600 duration-500">
                        Go Shopping
                    </a>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-6">
            @foreach ($orders as $order)
                <div
                    class="flex justify-between items-center bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-700">
                    <div class="flex flex-col gap-4">
                        <div class="mb-2">
                            <h2 class="text-2xl font-bold">Order #{{ $order->id }}</h2>
                            <p class="text-xl font-semibold">Total: <span
                                    class="font-semibold">${{ $order->total_price }}</span></p>
                        </div>
                        <p class="text-xl flex items-center gap-2">
                            <span class="font-semibold">Status:</span>
                            <span
                                class="p-2 px-4 font-bold rounded-lg shadow-lg text-center text-sm uppercase flex items-center tracking-wide justify-center
                            @if ($order->status == 'pending') bg-orange-500 text-white
                            @elseif($order->status == 'completed') bg-green-500 text-white
                            @elseif($order->status == 'proccessing') bg-slate-500 text-white
                            @else bg-red-500 text-white @endif">
                                {{ $order->status }}
                            </span>
                        </p>
                    </div>

                    <div class="text-right flex flex-col items-end">
                        <p class="text-gray-400">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                        <a href="{{ route('customer.order.show', $order->id) }}"
                            class="bg-blue-600 w-52 text-white py-2 px-4 rounded-lg mt-4 hover:bg-blue-500 transition duration-300 text-center">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
</x-layout>
