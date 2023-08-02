<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('List of Products') }}

                        @hasrole('administrator')
                            <x-button-inline wire:click="create" class="flex float-right ml-2 -mt-2">
                                <x-icon-file-plus />
                                <span class="ml-1">{{ __('Add') }}</span>
                            </x-button-inline>
                        @endhasrole

                        <div class="hidden float-right w-48 -mt-2 sm:block">
                            <select wire:model='branch_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('Branches')}}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hidden float-right w-48 mr-2 -mt-2 sm:block">
                            <select wire:model='subcategory_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('All Subcategories')}}</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hidden float-right w-48 mr-2 -mt-2 sm:block">
                            <select wire:model='category_id' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('Categories')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hidden float-right w-48 mr-2 -mt-2">
                            <select wire:model='category_id' class="peer font-normal h-9 w-full rblockounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                <option value="" selected>{{__('All Categories')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
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
                                    @hasrole('administrator')
                                        <x-th>{{ __('Show') }}</x-th>
                                        <x-th>{{ __('Recommend') }}</x-th>
                                        <x-th class="float-right">{{ __('Options') }}</x-th>
                                    @endhasrole
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>
                                            <img src="{{ Storage::url($product->image) }}" class="flex items-center justify-center text-xs w-12 h-12 bg-green-100 border border-green-400 rounded" alt="{{ $product->name }}">
                                        </x-td>
                                        <x-td>{{ $product->sku }}</x-td>
                                        <x-td>{{ $product->name }}</x-td>
                                        <x-td>${{ number_format($product->price, 2) }}</x-td>
                                        <x-td>${{ number_format($product->previous_price, 2) ?: '0.0' }}</x-td>
                                        <x-td>{{ $product->stock }}</x-td>
                                        <x-td>{{ $product->subcategory->name }}</x-td>
                                        <x-td>{{ $product->category->name }}</x-td>
                                        @hasrole('administrator')
                                            <x-td>
                                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                    <input type="checkbox" wire:click="setShow({{ $product }})" wire:loading.attr="disabled" class="sr-only peer" @if($product->show) checked @endif >
                                                    <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                                </label>
                                            </x-td>
                                            <x-td>
                                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                    <input type="checkbox" wire:click="setRecommend({{ $product }})" wire:loading.attr="disabled" class="sr-only peer" @if($product->recommend) checked @endif >
                                                    <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                                </label>
                                            </x-td>
                                            <x-td class="flex float-right">
                                                <x-button wire:click="edit({{ $product }})" wire:loading.attr="disabled" class="flex items-center mr-1 disabled:opacity-60">
                                                    <x-icon-edit />
                                                    <span class="hidden ml-2 sm:block">{{ __('Edit') }}</span>
                                                </x-button>

                                                <x-button-danger wire:click="delete({{ $product }})" wire:loading.attr="disabled" class="flex items-center disabled:opacity-60">
                                                    <x-icon-trash />
                                                    <span class="hidden ml-2 sm:block">{{ __('Delete') }}</span>
                                                </x-button-danger>
                                            </x-td>
                                        @endhasrole
                                    </x-tr>
                                @endforeach
                            </tbody>
                        </x-table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
