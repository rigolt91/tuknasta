<div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
    <div class="flex">
        <!--Manage Storage-->
        <span class="inline-flex items-center -ml-4 rounded-md">
            <a href="{{ route('admin-panel.panel') }}"
                class="inline-flex items-center px-2 py-2 -mt-5 -mb-3 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md sm:-mt-3 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                <svg fill="currentColor" class="h-6 sm:mr-2 sm:h-5 bi bi-shop" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                </svg>
                <span class="hidden lg:block">{{ __('Manage Store') }}</span>
            </a>
        </span>

        <!--Category Panel-->
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 mx-0.5 sm:mx-0 sm:bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-card-checklist lg:hidden" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Categories') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.categories') }}" class="flex items-center">
                    {{ __('List of Categories') }}
                </x-dropdown-link>
                @hasrole(['administrator', 'editor'])
                    <x-dropdown-link wire:click="createCategory" class="flex items-center cursor-pointer">
                        {{ __('Add Category') }}
                    </x-dropdown-link>
                @endhasrole
            </x-slot>
        </x-dropdown>

        <!--Subcategory Panel-->
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 mx-0.5 sm:mx-0 sm:bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-card-list lg:hidden" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Subcategories') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.subcategories') }}" class="flex items-center">
                    {{ __('List of Subcategories') }}
                </x-dropdown-link>
                @hasrole(['administrator', 'editor'])
                    <x-dropdown-link wire:click="createCategory" class="flex items-center cursor-pointer">
                        {{ __('Add Subcategory') }}
                    </x-dropdown-link>
                @endhasrole
            </x-slot>
        </x-dropdown>

        <!--Product Panel-->
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 mx-0.5 sm:mx-0 sm:bg-white bg-gray-100 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-box-seam-fill lg:hidden" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003 6.97 2.789ZM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461L10.404 2Z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Products') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.products') }}" class="flex items-center">
                    {{ __('List of Products') }}
                </x-dropdown-link>
                @hasrole(['administrator', 'editor'])
                    <x-dropdown-link wire:click="createProduct" class="flex items-center cursor-pointer">
                        {{ __('Add Product') }}
                    </x-dropdown-link>
                @endhasrole
            </x-slot>
        </x-dropdown>

        @hasrole('administrator')
        <!--Branches Panel-->
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center mx-0.5 sm:mx-0 -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 sm:bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-houses lg:hidden" viewBox="0 0 16 16">
                            <path d="M5.793 1a1 1 0 0 1 1.414 0l.647.646a.5.5 0 1 1-.708.708L6.5 1.707 2 6.207V12.5a.5.5 0 0 0 .5.5.5.5 0 0 1 0 1A1.5 1.5 0 0 1 1 12.5V7.207l-.146.147a.5.5 0 0 1-.708-.708L5.793 1Zm3 1a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708L8.793 2Zm.707.707L5 7.207V13.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5V7.207l-4.5-4.5Z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Suppliers') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.branches') }}" class="flex items-center">
                    {{ __('List of Suppliers') }}
                </x-dropdown-link>
                    <x-dropdown-link wire:click="createBranch" class="flex items-center cursor-pointer">
                        {{ __('Add Suppliers') }}
                    </x-dropdown-link>
            </x-slot>
        </x-dropdown>
        @endhasrole

        <!--Orders Panel-->
        <x-dropdown align="none" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center bg-gray-100 mx-0.5 lg:mx-0 -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 sm:bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-file-earmark-text-fill sm:hidden" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Orders') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.orders') }}" class="flex items-center">
                    {{ __('List of Orders') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="searchOrder" class="flex items-center cursor-pointer">
                    {{ __('Search Order') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>

        <!--Report Panel-->
        <x-dropdown align="none" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center -mt-2.5 -mb-3 px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 sm:mx-0 mx-0.5 sm:bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        <svg fill="currentColor" class="h-6 bi bi-file-earmark-bar-graph lg:hidden" viewBox="0 0 16 16">
                            <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z" />
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                        <span class="hidden lg:block">{{ __('Reports') }}</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route('admin-panel.report.sales-in-the-week-by-supplier') }}" class="flex items-center cursor-pointer">
                    {{ __('Sales in the Week by Supplier') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="dailySales" class="flex items-center cursor-pointer">
                    {{ __('Daily Sales') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="weeklySales" class="flex items-center cursor-pointer">
                    {{ __('Weekly Sales') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="monthlySales" class="flex items-center cursor-pointer">
                    {{ __('Monthly Sales') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="yearSales" class="flex items-center cursor-pointer">
                    {{ __('Year Sales') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>

        @hasrole('administrator')
            <!--Rate Transportation Panel-->
            <x-link href="{{ route('rate-transportation') }}" :active="request()->routeIs('rate-transportation')" class="hidden px-1 ml-2 sm:block">
                <span class="text-gray-500 hover:text-gray-700">{{ __('Rate Transportation') }}</span>
            </x-link>
            <!--Slider Panel-->
            <x-link href="{{ route('sliders') }}" :active="request()->routeIs('sliders')" class="hidden px-1 ml-2 sm:block">
                <span class="text-gray-500 hover:text-gray-700">{{ __('Sliders') }}</span>
            </x-link>
            <!--UpagosDirect Panel-->
            <x-link href="{{ route('upagosdirect') }}" :active="request()->routeIs('upagosdirect')" class="hidden px-1 ml-2 sm:block">
                <span class="text-gray-500 hover:text-gray-700">{{ __('Settings') }}</span>
            </x-link>
        @endhasrole
    </div>
</div>
