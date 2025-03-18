<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Hero Section --}}
    @if ($indexDashboard)
        {{-- foto --}}
        {{-- <section class="relative w-full h-screen flex flex-col justify-center items-center bg-black pt-16">
            <img src="{{ asset('asset/images/products/'. $indexDashboard->images[0] )}}" alt="Homepage Image" class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="relative text-center text-white p-4 z-10">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $indexDashboard->name }}</h1>
                <p class="text-lg md:text-2xl mb-6">Discover the best products for your needs</p>
                <a href="{{ route('product.showCustomer',$indexDashboard->slug) }}" class="inline-block bg-indigo-600 rounded-full px-10 py-4 text-lg md:text-xl font-medium hover:bg-indigo-700 transition duration-300 shadow-lg">
                    Shop Now
                </a>
            </div>
        </section> --}}

        {{-- video --}}
        <section class="relative w-full h-[calc(100vh-3.5rem)] flex flex-col justify-end items-center bg-black">
            <video autoplay muted loop class="absolute inset-0 h-full w-full object-cover object-center opacity-70">
                <source src="{{ asset('asset/videos/dashboard/abF0uRhidP4hdUBc2Jmir_desktop.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="text-center text-white p-4 z-10 mb-14 w-full max-w-lg">
                <h1 class="text-2xl font-bold mb-4">{{ $indexDashboard->name }}</h1>
                <p class="text-lg md:text-2xl mb-6">Discover the best products for your needs</p>
                <a href="{{ route('customer.product.show', $indexDashboard->slug) }}"
                    class="inline-block w-full bg-slate-800 rounded-lg px-10 py-4 text-lg md:text-xl font-medium hover:bg-slate-700 transition duration-300 shadow-lg">
                    Shop Now
                </a>
            </div>
        </section>
    @else
        <section class="relative w-full h-screen flex flex-col justify-center items-center bg-black pt-16">
            <img src="{{ asset('asset/images/dashboard/Homepage.avif') }}" alt="Homepage Image"
                class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="relative text-center text-white p-4 z-10">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome</h1>
                <p class="text-lg md:text-2xl mb-6">Discover the best products for your needs</p>
                <a href="{{ route('product.indexCustomer') }}"
                    class="inline-block bg-indigo-600 rounded-full px-10 py-4 text-lg md:text-xl font-medium hover:bg-indigo-700 transition duration-300 shadow-lg">
                    Shop Now
                </a>
            </div>
        </section>
    @endif

    {{-- Best Sellers --}}

    <section class="mx-auto py-8 md:py-16 px-4 lg:px-20 text-white">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-semibold">Best Sellers</h2>
            <p class="mt-4 text-lg text-gray-400">Check out our top-selling products</p>
        </div>
        <div class="product-grid">
            @foreach ($bestSeller as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

</x-layout>
