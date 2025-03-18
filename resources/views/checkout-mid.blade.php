<x-layout class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-10">
    <x-slot:title>{{ $title }}</x-slot:title>

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
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-4xl mb-4 font-bold">Checkout</h1>
        <form action="{{ route('customer.order.store') }}" method="POST" class="flex flex-col lg:flex-row gap-8" id="checkout-form">
            <div class="text-white bg-gray-800 p-6 rounded-lg shadow-lg lg:w-2/3 h-full">
                <div class="border-b border-gray-900/10 pb-6">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium leading-6 text-white">First name</label>
                            <div class="mt-2">
                                <input type="text" name="first_name" id="first_name" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium leading-6 text-white">Last name</label>
                            <div class="mt-2">
                                <input type="text" name="last_name" id="last_name" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium leading-6 text-white">Phone</label>
                            <div class="mt-2">
                                <input type="text" name="phone" id="phone" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <label for="address" class="block text-sm font-medium leading-6 text-white">Address</label>
                            <div class="mt-2">
                                <input type="text" name="address" id="address" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <label for="city" class="block text-sm font-medium leading-6 text-white">City</label>
                            <div class="mt-2">
                                <input type="text" name="city" id="city" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="postal_code" class="block text-sm font-medium leading-6 text-white">Postal Code</label>
                            <div class="mt-2">
                                <input type="text" name="postal_code" id="postal_code" required
                                    class="block w-full rounded-md bg-gray-700 py-2 text-white shadow-sm ring-1 ring-inset ring-gray-500 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8 lg:w-1/3">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Basket Summary</h2>
                    @foreach ($itemCarts as $itemCart)
                        <div class="flex items-center gap-4 p-4 border-b border-gray-700">
                            <img src="{{ asset('asset/images/products/' . $itemCart->product->images[0]) }}"
                                alt="Product Image" class="w-14 h-w-14 object-cover rounded-lg shadow-lg">
                            <div class="flex-grow">
                                <h3 class="text-md font-semibold">{{ $itemCart->product->name }}</h3>
                                <p class="text-sm text-gray-300">Price: ${{ $itemCart->product->price }}</p>
                                <p class="text-sm text-gray-300">Quantity: {{ $itemCart->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-md font-bold">${{ $itemCart->total }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                    <div class="flex justify-between mb-4">
                        <span>Subtotal</span>
                        <span>${{ $itemCarts->sum('total') }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span>Tax (0.93%)</span>
                        <span>${{ number_format($itemCarts->sum('total') * 0.0093, 2) }}</span>
                    </div>
                    <div class="flex font-bold justify-between mb-4">
                        <span>Total</span>
                        <span>${{ number_format($itemCarts->sum('total') + $itemCarts->sum('total') * 0.0093, 2) }}</span>
                    </div>

                    @csrf
                    <input type="hidden" name="snap_token" id="snap_token" value="{{ $snapToken }}">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-300">Checkout</button>
                </div>
            </div>
        </form>
    </section>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop form from submitting immediately
            var snapToken = document.getElementById('snap_token').value;

            // Create a Snap API request
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Handle the successful payment here
                    // document.getElementById('checkout-form').submit(); // Submit the form
                    alert('Payment is success.');
                },
                onPending: function(result) {
                    // Handle pending payment here
                    alert('Payment is pending.');
                },
                onError: function(result) {
                    // Handle error here
                    alert('Payment failed: ' + result.message);
                }
            });
        });
    </script>
</x-layout>
