<div class="flex">

    <!--Manage Storage-->
    <span class="inline-flex items-center -ml-4 rounded-md">
        <a href="{{ route('admin-panel.panel') }}" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
            <svg fill="currentColor" class="h-5 mr-2 bi bi-shop" viewBox="0 0 16 16">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
            </svg>
            {{ __('Manage Store') }}
        </a>
    </span>

    <!--Category Panel-->
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Category') }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="{{ route('admin-panel.categories') }}" class="flex items-center">
                {{ __('Category List') }}
            </x-dropdown-link>

            <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.category.create')" class="flex items-center cursor-pointer">
                {{ __('New Category') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>

    <!--Subcategory Panel-->
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Subcategory') }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="{{ route('admin-panel.subcategories') }}" class="flex items-center">
                {{ __('List of Subcategory') }}
            </x-dropdown-link>

            <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.sub-category.create')" class="flex items-center cursor-pointer">
                {{ __('New Subcategory') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>

    <!--Product Panel-->
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Product') }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="{{ route('admin-panel.products') }}" class="flex items-center">
                {{ __('List of Products') }}
            </x-dropdown-link>

            <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.product.create')" class="flex items-center cursor-pointer">
                {{ __('New Product') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>

    <!--Branches Panel-->
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Branches') }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="{{ route('admin-panel.branches') }}" class="flex items-center">
                {{ __('List of branches') }}
            </x-dropdown-link>

            <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.branch.create')" class="flex items-center cursor-pointer">
                {{ __('New Branch') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>

    <!--Branches Panel-->
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button" class="inline-flex items-center -mt-2.5 -mb-3 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Orders') }}

                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </span>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="{{ route('admin-panel.orders') }}" class="flex items-center">
                {{ __('List of orders') }}
            </x-dropdown-link>

            <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.order.search')" class="flex items-center cursor-pointer">
                {{ __('Search Order') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>
