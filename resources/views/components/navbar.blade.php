<!-- resources/views/components/navbar.blade.php -->

<nav class="bg-gray-900" x-data="{ isOpen: false, isUserMenuOpen: false }" class="">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="px-3 py-2 text-lg font-bold">
                        <span class="tracking-[0.2rem]">Abdi jaya</span> <span class="mx-4">|</span> Shop
                    </h1>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href="{{ route('dashboard.customer') }}" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="{{ route('customer.product.index') }}" :active="request()->is('product')">Product</x-nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <a href="{{ route('cart.index') }}"
                        class="flex items-center justify-center p-2 rounded-full text-gray-400 hover:text-white hover:bg-gray-700 cursor-pointer relative">
                        <i class="fa fa-shopping-cart"></i>
                        @if (isset($cartCount) && $cartCount > 0)
                            <div
                                class="absolute top-0 right-0 transform translate-x-1 -translate-y-1 bg-red-500 text-white p-1 rounded-full text-xs w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}</div>
                        @endif
                    </a>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ isUserMenuOpen: false }">
                        <div class="flex gap-5">
                            <button type="button" @click="isUserMenuOpen = !isUserMenuOpen"
                                class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                            </button>
                        </div>

                        <div x-show="isUserMenuOpen" @click.outside="isUserMenuOpen = false"
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-slate-800 py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-white"
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="{{ route('customer.order.index') }}" class="block px-4 py-2 text-sm text-white"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">Order History</a>
                            <form id="logout" action="{{ route('logout.customer') }}" method="POST" class="">
                                @csrf
                                <button href="" class="block px-4 py-2 text-sm text-white" role="menuitem"
                                    tabindex="-1" id="user-menu-item-2">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium"
                aria-current="page">Home</a>
            <a href="{{ route('customer.product.index') }}"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Product</a>
            <a href="{{ route('cart.index') }}"
                class="text-gray-300 hover:bg-gray-700 hover:text-white  rounded-md px-3 py-2 text-base font-medium flex items-center justify-between">
                Cart
                @if (isset($cartCount) && $cartCount > 0)
                    <div class="p-2 rounded-full text-md w-6 h-6 bg-white flex items-center justify-center text-slate-900 font-semibold">{{ $cartCount }}</div>
                @endif
            </a>
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                    <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.index') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                    Profile</a>
                <a href="{{ route('customer.order.index') }}"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Order
                    History</a>
                <form id="logout" action="{{ route('logout.customer') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="text-left w-full block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                        out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
