<div>
    <nav id="navBarFixed" wire:ignore.self class="fixed z-50 hidden w-full bg-gray-100 shadow-md opacity-90 scroll-mt-2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:mb-0 sm:border-none sm:mx-0 mx-4">
                <div class="flex items-center sm:-my-px sm:m-0">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="hidden w-auto h-10 md:block" />
                            <x-application-sm width="40" height="40" class="block md:hidden" />
                        </a>
                    </div>
                    <!-- Navigation Links -->
                    <div class="flex items-center mx-12 space-x-2 sm:space-x-4 sm:-my-px md:mx-28">
                        <x-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="uppercase sm:block">
                            <span class="text-xs sm:text-sm">{{ __('Home') }}</span>
                        </x-link>

                        <x-link href="{{ route('products') }}" :active="request()->routeIs('products')" class="uppercase sm:block">
                            <span class="text-xs sm:text-sm">{{ __('Products') }}</span>
                        </x-link>

                        <x-link href="{{ route('wholesaler') }}" :active="request()->routeIs('wholesaler')" class="uppercase sm:block">
                            <span class="text-xs sm:text-sm">{{ __('Wholesaler') }}</span>
                        </x-link>
                    </div>
                </div>

                <div class="flex items-center w-auto">
                    <div>
                        <form action="{{ route('products') }}" class="flex hidden w-full right-16 sm:block" method="get">
                            <div class="flex items-center justify-end mr-4">
                                <input name="search" type="search"
                                    class="w-48 px-6 border-indigo-700 shadow md:w-56 h-9 rounded-l-md focus:border-white focus:ring-indigo-500"
                                    placeholder="{{ __('Search products') }}..." />
                                <x-button-inline type="submit"
                                    class="px-3 bg-indigo-700 border border-indigo-700 rounded-l-none shadow">
                                    <svg height="18" width="18" fill="white" class="bi bi-search"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </x-button-inline>
                            </div>
                        </form>
                    </div>

                    <!--Shopping Cart-->
                    <div class="flex justify-end iems-center">
                        @include('livewire.cart.cart-component')
                    </div>
                </div>

            </div>
        </div>
    </nav>
</div>
