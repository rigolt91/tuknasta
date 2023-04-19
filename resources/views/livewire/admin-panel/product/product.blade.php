<div class="py-12">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 -mt-2 mb-2 border-b border-green-300 font-bold">
                        {{ __('List of Products') }}

                        <x-button-inline wire:click="$emit('openModal', 'admin-panel.product.create')" class="float-right -mt-2 flex">
                            <x-icon-file-plus />
                            <span class="ml-1">{{ __('New') }}</span>
                        </x-button-inline>

                        <div class="-mt-2 mr-4 float-right w-48">
                            <select wire:model='branch_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('All Branches')}}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="-mt-2 mr-4 float-right w-48">
                            <select wire:model='subcategory_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('All Subcategories')}}</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="-mt-2 mr-4 float-right w-48">
                            <select wire:model='category_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('All Categories')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-table class="w-full">
                        <x-thead >
                            <x-tr>
                                <x-th>#</x-th>
                                <x-th>{{ __('Photo') }}</x-th>
                                <x-th>{{ __('Inventory') }}</x-th>
                                <x-th>{{ __('Name') }}</x-th>
                                <x-th>{{ __('Price') }}</x-th>
                                <x-th>{{ __('Previous Price') }}</x-th>
                                <x-th>{{ __('Stock') }}</x-th>
                                <x-th>{{ __('Subcategory') }}</x-th>
                                <x-th>{{ __('Category') }}</x-th>
                                <x-th>{{ __('Show') }}</x-th>
                                <x-th>{{ __('Recommend') }}</x-th>
                                <x-th class="float-right">{{ __('Options') }}</x-th>
                            </x-tr>
                        </x-thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <x-tr wire:loading.class="opacity-60">
                                    <x-td>{{ ++$key }}</x-td>
                                    <x-td>
                                        <img src="{{ Storage::url($product->image) }}" class="h-12 w-12 border border-green-400 bg-green-100 rounded" alt="{{ $product->name }}">
                                    </x-td>
                                    <x-td>{{ $product->sku }}</x-td>
                                    <x-td>{{ $product->name }}</x-td>
                                    <x-td>${{ number_format($product->price, 2) }}</x-td>
                                    <x-td>${{ number_format($product->previous_price, 2) ?: '0.0' }}</x-td>
                                    <x-td>{{ $product->stock }}</x-td>
                                    <x-td>{{ $product->subcategory->name }}</x-td>
                                    <x-td>{{ $product->category->name }}</x-td>
                                    <x-td>
                                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                            <input type="checkbox" wire:click="setShow({{ $product->id }})" class="sr-only peer" @if($product->show) checked @endif >
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </x-td>
                                    <x-td>
                                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                            <input type="checkbox" wire:click="setRecommend({{ $product->id }})" class="sr-only peer" @if($product->recommend) checked @endif >
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </x-td>
                                    <x-td class="float-right">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <x-button-inline class="mt-1.5">
                                                    <x-icon-points class="-ml-2 -mr-2" />
                                                </x-button-inline>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.product.edit', [{{$product->id}}])" class="flex items-center" style="cursor:pointer">
                                                    <x-icon-edit />
                                                    <span class="ml-2">{{ __('Edit') }}</span>
                                                </x-dropdown-link>

                                                <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.product.destroy', [{{$product->id}}])" class="flex items-center" style="cursor: pointer">
                                                    <x-icon-trash />
                                                    <span class="ml-2">{{ __('Delete') }}</span>
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </x-td>
                                </x-tr>
                            @endforeach
                        </tbody>
                    </x-table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
