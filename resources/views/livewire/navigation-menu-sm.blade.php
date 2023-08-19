<div>
    <nav id="navBarFixed" class="fixed z-50 hidden w-full bg-gray-100 shadow-md opacity-90 scroll-mt-2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:mb-0 sm:border-none">
                <div class="relative flex items-center sm:-my-px sm:m-0">
                    <!-- Logo -->
                    <div class="absolute left-0 flex items-center -top-3">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo width="90" height="24" class="hidden md:block md:ml-0" />
                            <x-application-sm width="50" height="50" class="block md:hidden md:ml-0" />
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

                <div class="relative flex items-center w-auto">
                    <form action="{{ route('products') }}" class="absolute flex hidden w-full right-16 sm:block" method="get">
                        <div class="flex items-center justify-end mr-4">
                            <input name="search" type="search"
                                class="w-48 px-6 border-green-700 shadow md:w-56 h-9 rounded-l-md focus:border-white focus:ring-green-500"
                                placeholder="{{ __('Search products') }}..." />
                            <x-button-inline type="submit"
                                class="px-3 bg-green-700 border border-green-700 rounded-l-none shadow">
                                <svg height="18" width="18" fill="white" class="bi bi-search"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </x-button-inline>
                        </div>
                    </form>

                    <!--Shopping Cart-->
                    <div class="absolute flex justify-end iems-center right-1">
                        @include('livewire.cart.cart-component')
                    </div>
                </div>

            </div>
        </div>
    </nav>
</div>
