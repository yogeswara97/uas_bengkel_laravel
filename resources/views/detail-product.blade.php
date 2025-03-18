<x-layout class="mx-autolg:py-6 sm:px-2 lg:px-10">
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- detail product --}}
    <section class="container mx-auto px-4 py-6">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (session('success'))
            <div class="bg-blue-900 text-white p-3 md:p-4 rounded mb-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-sm md:text-lg">{{ session('success') }}</h2>
                    <div class="flex flex-col md:flex-row gap-2 md:gap-4">
                        <a href="{{ route('cart.index') }}" class="bg-white text-slate-700 px-4 py-2 rounded-lg font-semibold text-center hover:bg-gray-300 transition duration-300">View Cart</a>
                        <a href="/product" class="bg-white text-slate-700 px-4 py-2 rounded-lg font-semibold text-center hover:bg-gray-300 transition duration-300">Add More Products</a>
                    </div>
                </div>
            </div>
        @endif




        <div class="flex flex-col lg:flex-row justify-center gap-10">
            <div class="flex-1">
                <div id="default-carousel" class="relative" data-carousel="static">
                    <div class="overflow-hidden relative rounded-lg h-[450px] md:h-[700px] lg:h-[900px]">
                        @foreach ($product->images as $index => $image)
                            <div class="{{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out transform transition-all"
                                data-carousel-item>
                                <img src="{{ asset('asset/images/products/' . $image) }}"
                                    class="w-full h-full object-cover transition-all"
                                    alt="Product Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                        @foreach ($product->images as $index => $image)
                            <button type="button"
                                class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-600' : 'bg-gray-400' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"
                                data-carousel-slide-to="{{ $index }}"></button>
                        @endforeach
                    </div>

                    <button type="button"
                        class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gray-950 group-focus:outline-none">
                            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="hidden">Anterior</span>
                        </span>
                    </button>
                    <button type="button"
                        class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gray-950 group-focus:outline-none">
                            <svg class="w-5 h-5 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            <span class="hidden">Siguiente</span>
                        </span>
                    </button>
                </div>

                <div class="flex gap-2 overflow-x-auto mt-5">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('asset/images/products/' . $image) }}" alt=""
                            class="w-24 md:w-36 h-auto">
                    @endforeach
                </div>
            </div>
            <div class="flex-none w-full lg:w-96 p-3 max-w-full">
                <h1 class="text-3xl md:text-4xl mb-2 font-bold">{{ $product->name }}</h1>
                <h2 class="text-2xl mb-4 font-semibold">${{ $product->price }}</h2>
                <div class="my-4">
                    <h3 class="text-lg md:text-xl">Quantity</h3>
                    <div class="flex my-3 items-center gap-3">
                        <div class="cursor-pointer" id="quantity-minus">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                        <input type="number" id="quantityInput" disabled
                            class="text-white text-center border border-gray-300 opacity-50 focus:opacity-100 focus:transition-all focus:duration-500 bg-transparent h-10 w-16 md:w-20"
                            value="1" min="1">
                        <div class="cursor-pointer" id="quantity-plus">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                    </div>
                    <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" class="text-black" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" class="text-black" id="quantityHiddenInput" name="quantity"
                            value="1">
                        <input type="hidden" class="text-black" id="totalPrice" name="total"
                            value="{{ $product->price }}">
                        <button type="submit"
                            class="bg-gray-950 rounded-lg w-full hover:scale-95 hover:bg-slate-600 duration-500">
                            <div class="p-4 font-medium text-lg">Add to Cart</div>
                        </button>
                    </form>
                </div>
                <div>
                    <h5 class="text-xl mb-3">Description</h5>
                    <div class="text-sm leading-relaxed prose prose-sm text-white">{!! $product->description !!}</div>
                </div>
            </div>
        </div>

    </section>


    {{-- Recomended product --}}
    <section class="container mx-auto px-4 py-2 mt-5">
        <h1 class="text-4xl mb-7">Recomended Products</h1>
        <div class="product-grid">
            @foreach ($recommendedProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <script>
        const btnPlus = document.getElementById('quantity-plus');
        const btnMinus = document.getElementById('quantity-minus');
        const qtyInput = document.getElementById('quantityInput');
        const qtyHiddenInput = document.getElementById('quantityHiddenInput');
        const totalPrice = document.getElementById('totalPrice');

        const unitPrice = {{ $product->price }};
        const maxStock = {{ $product->stock }};
        let currentQuantity = parseInt(qtyInput.value);


        btnPlus.addEventListener('click', function() {

            if (currentQuantity < maxStock) {
                currentQuantity++;
                qtyInput.value = currentQuantity;
                qtyHiddenInput.value = currentQuantity;
                totalPrice.value = `${(unitPrice * currentQuantity).toFixed(2)}`;
            } else {
                alert('Sorry, we are out of stock');
            }
        });

        btnMinus.addEventListener('click', function() {

            if (currentQuantity > 1) {
                currentQuantity--;
                qtyInput.value = currentQuantity;
                qtyHiddenInput.value = currentQuantity;
                totalPrice.value = `${(unitPrice * currentQuantity).toFixed(2)}`;
            }
        });
    </script>

</x-layout>
