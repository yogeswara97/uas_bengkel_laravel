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
        <h1 class="text-4xl mb-4">Cart</h1>

        @if ($itemCarts->isEmpty())
            <div class="flex flex-col items-center w-full md:items-start py-5 px-9">
                <h1 class="text-xl mb-8">Your cart is Empty.</h1>
                <div class="flex gap-4 w-full md:w-96">
                    <a href="{{ route('customer.product.index') }}"
                        class="bg-slate-900 py-4 px-6 rounded-lg text-center w-full hover:scale-95 hover:bg-slate-600 duration-500">
                        Go Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="flex flex-col gap-4 md:flex-row">
                <div class="flex-grow md:basis-4/5">
                    <div class="space-y-4">
                        @foreach ($itemCarts as $itemCart)
                            <div class="flex flex-row justify-between bg-gray-800 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center gap-2 md:gap-4 md:mb-0">
                                    <img src="{{ asset('asset/images/products/' . $itemCart->product->images[0]) }}"
                                        alt="Product Image" class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg">
                                    <div class="flex flex-col gap-2">
                                        <h2 class="text-lg md:text-xl">{{ $itemCart->product->name }}</h2>
                                        <form action="{{ route('cart.update', $itemCart->id) }}" method="POST"
                                            class="update-cart-form" data-max-stock="{{ $itemCart->product->stock }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center">
                                                <button type="button"
                                                    class="quantity-decrease bg-gray-500 bg-opacity-50 hover:bg-opacity-85 text-white py-1 px-3 md:py-2 md:px-4 rounded-lg"
                                                    data-id="{{ $itemCart->id }}">-</button>
                                                <input type="number" name="quantity"
                                                    class="text-white text-center bg-transparent h-8 w-10 md:h-10 md:w-14 border-none quantity-input"
                                                    value="{{ $itemCart->quantity }}" min="1" readonly>
                                                <button type="button"
                                                    class="quantity-increase bg-gray-500 bg-opacity-50 hover:bg-opacity-85 text-white py-1 px-3 md:py-2 md:px-4 rounded-lg"
                                                    data-id="{{ $itemCart->id }}">+</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    <p class="text-lg md:text-xl">${{ number_format($itemCart->total, 2) }}</p>
                                    <form action="{{ route('cart.destroy', $itemCart->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-sm bg-opacity-30 hover:bg-opacity-55 py-1 px-2 rounded-lg border border-red-500 text-white">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



                <!-- Order Summary Section with updated classes -->
                <form action="{{ route('checkout') }}" method="GET" class="md:basis-1/2 md:px-4 ">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl mb-4">Order Summary</h2>
                        <div class="flex justify-between mb-4">
                            <span>Subtotal</span>
                            <span>${{ number_format($itemCarts->sum('total'), 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span>tax(0.93%)</span>
                            <span>${{ number_format($itemCarts->sum('total') * 0.0093, 2) }}</span>
                        </div>
                        <div class="flex font-bold justify-between mb-4">
                            <span>total</span>
                            <span>${{ number_format($itemCarts->sum('total') + $itemCarts->sum('total') * 0.0093, 2) }}</span>
                        </div>

                        @csrf
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-300">Checkout</button>
                    </div>
                </form>
            </div>
        @endif
    </section>

    <script>
        document.querySelectorAll('.quantity-decrease').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.update-cart-form');
                const input = form.querySelector('.quantity-input');
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    form.submit();
                }
            });
        });

        document.querySelectorAll('.quantity-increase').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.update-cart-form');
                const input = form.querySelector('.quantity-input');
                const currentQuantity = parseInt(input.value);  // Correct variable name
                const maxStock = parseInt(form.getAttribute('data-max-stock'));

                if (currentQuantity < maxStock) {
                    input.value = currentQuantity + 1;
                    form.submit();
                } else {
                    alert('You cannot add more than the available stock.');
                }
            });
        });
    </script>


</x-layout>
