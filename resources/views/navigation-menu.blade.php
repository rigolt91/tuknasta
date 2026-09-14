<div class="contents">
    <div class="border-b bg-indigo-50/60 border-indigo-100/80">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-10 mb-1 sm:mb-0 text-xs">
                <span class="hidden text-indigo-800/80 sm:block">
                    {{ __('Shipping by municipality') }} · {{ __('secure card payment') }}
                </span>

                <div class="flex items-center gap-3">
                    @auth
                        <span class="hidden text-indigo-800/80 sm:block">{{ Auth::user()->name }}</span>
                    @endauth

                    <!--Idioma -->
                    <div>
                        @livewire('lang-app')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="sticky top-0 z-40 border-b border-gray-100 shadow-sm bg-white/90 backdrop-blur">
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4 mb-1 border-b sm:mb-0 sm:border-none">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="hidden w-auto h-12 md:block -ml-4" />
                        <x-application-sm width="42" height="42" class="block md:hidden" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-wrap items-center gap-x-6 gap-y-1">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
                        {{ __('Products') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('wholesaler') }}" :active="request()->routeIs('wholesaler')">
                        {{ __('Wholesaler') }}
                    </x-nav-link>
                </div>

                <!-- Searh -->
                <div class="items-center justify-center flex-1 hidden max-w-md sm:flex">
                    @livewire('search-bar-component')
                </div>

                <!--Account + Shopping Cart-->
                <div class="flex items-center justify-end gap-2 shrink-0">
                    <!-- Settings Dropdown -->
                    <div class="relative">
                        @auth
                            <x-dropdown align="right" width="64" dropdownClasses="-mt-4">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button type="button" aria-haspopup="menu" :aria-expanded="open"
                                            aria-label="{{ __('Account') }} ({{ Auth::user()->name }})"
                                            class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                                            <img class="object-cover w-10 h-10 rounded-full"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="" />
                                        </button>
                                    @else
                                        <button type="button" aria-haspopup="menu" :aria-expanded="open"
                                            aria-label="{{ __('Account') }} ({{ Auth::user()->name }})"
                                            class="relative flex items-center justify-center w-10 h-10 text-indigo-700 transition duration-150 ease-in-out bg-white border border-gray-200 rounded-full hover:border-indigo-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                                            <svg height="18" width="18" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            </svg>
                                        </button>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    @hasrole(['administrator', 'editor'])
                                        <x-dropdown-link href="{{ route('admin-panel.panel') }}" class="flex items-center">
                                            <svg height="24" width="24" fill="currentColor" class="h-5 mr-2 bi bi-shop"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                                            </svg>
                                            {{ __('Manage Store') }}
                                        </x-dropdown-link>
                                    @endhasrole

                                    @hasrole('editor')
                                        <x-dropdown-link href="{{ route('admin-panel.orders') }}"
                                            class="flex items-center cursor-pointer">
                                            <svg height="24" width="24" fill="currentColor"
                                                class="h-5 mr-2 bi bi-card-list" viewBox="0 0 16 16">
                                                <path
                                                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                                <path
                                                    d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                            </svg>
                                            {{ __('Orders') }}
                                        </x-dropdown-link>
                                    @else
                                        <x-dropdown-link href="{{ route('profile.my-orders') }}"
                                            class="flex items-center cursor-pointer">
                                            <svg height="24" width="24" fill="currentColor"
                                                class="h-5 mr-2 bi bi-card-list" viewBox="0 0 16 16">
                                                <path
                                                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                                <path
                                                    d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                            </svg>
                                            {{ __('My Orders') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link
                                            wire:click="$emit('openModal', 'profile.my-contact.my-contact-component')"
                                            class="flex items-center cursor-pointer">
                                            <svg height="24" width="24" fill="currentColor"
                                                class="h-5 mr-2 bi bi-person-lines-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                                            </svg>
                                            {{ __('My Contacts') }}
                                        </x-dropdown-link>
                                    @endhasrole

                                    <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center">
                                        <svg height="24" width="24" fill="currentColor"
                                            class="h-5 mr-2 bi bi-wrench-adjustable-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                                        </svg>
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    @hasrole('administrator')
                                        <x-dropdown-link ink href="{{ route('admin-panel.users') }}" class="flex items-center">
                                            <svg height="24" width="24" fill="currentColor" class="h-5 mr-2 bi bi-people"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                                            </svg>
                                            {{ __('Users') }}
                                        </x-dropdown-link>
                                    @endhasrole

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                            {{ __('API Tokens') }}
                                        </x-dropdown-link>
                                    @endif

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                            class="flex items-center">
                                            <svg height="24" width="24" fill="currentColor"
                                                class="h-5 mr-2 bi bi-arrow-right-square" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                            </svg>
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <div class="flex items-center pb-1">
                                <x-link :href="route('login')" :active="request()->routeIs('login')" aria-label="{{ __('Account') }}">
                                    <svg height="32" width="32" fill="currentColor" class="text-indigo-800 bi bi-person-fill"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg>
                                </x-link>
                                <x-link :href="route('login')" :active="request()->routeIs('login')" aria-hidden="true" tabindex="-1">
                                    <div class="hidden text-indigo-800 sm:block active:text-indigo-600">{{ __('Account') }}
                                    </div>
                                </x-link>

                                <span class="hidden pt-1 mx-1 text-gray-400 sm:block">/</span>

                                <x-link :href="route('register')" :active="request()->routeIs('register')" aria-label="{{ __('Register') }}">
                                    <div class="hidden text-indigo-800 sm:block active:text-indigo-600">{{ __('Register') }}
                                    </div>
                                </x-link>
                            </div>
                        @endauth
                    </div>

                    @livewire('cart.cart-component')
                </div>
            </div>

            <!-- Searh -->
            <div class="items-center justify-center w-full mb-2 sm:hidden">
                <form action="{{ route('dashboard') }}" class="flex overflow-hidden border border-gray-200 rounded-full" method="get">
                    <label for="search-products-mobile" class="sr-only">{{ __('Search products') }}</label>
                    <input id="search-products-mobile" name="search" type="search"
                        class="block w-full border-none focus:ring-indigo-500"
                        placeholder="{{ __('Search products') }}" />
                    <button type="submit" aria-label="{{ __('Search products') }}" class="flex items-center justify-center px-4 text-white bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                        <svg width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
