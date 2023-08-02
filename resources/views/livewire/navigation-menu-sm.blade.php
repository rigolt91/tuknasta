<div>
    <nav id="navBarFixed" class="hidden fixed z-50 bg-gray-100 w-full opacity-90 shadow-md scroll-mt-2">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 mb-1 border-b sm:mb-0 sm:border-none">
                <div class="sm:-my-px mx-4 sm:m-0 flex">
                    <!-- Logo -->
                    <div class="flex items-center sm:mr-12">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo width="90" height="24" class="hidden sm:block -ml-4 sm:ml-0" />
                            <x-application-sm width="60" height="60" class="block sm:hidden -ml-4 sm:ml-0" />
                        </a>
                    </div>
                    <!-- Navigation Links -->
                    <div class="space-x-2 sm:space-x-4 sm:-my-px mx-4 sm:mx-4 flex items-center">
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
                    <form action="{{ route('products') }}" class="flex w-full hidden sm:block" method="get">
                        <div class="flex items-center justify-end mr-4">
                            <input name="search" type="search"
                                class="px-6 w-56 h-9 rounded-l-md border-green-700 focus:border-white focus:ring-green-500 shadow"
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
                    <div class="flex items-center justify-end">
                        @include('livewire.cart.cart-component')
                    </div>
                </div>

            </div>
        </div>
    </nav>
</div>
