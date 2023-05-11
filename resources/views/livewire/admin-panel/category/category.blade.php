<div class="py-12">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('List of Categories') }}

                        <x-button-inline wire:click="$emit('openModal', 'admin-panel.category.create')" class="flex float-right -mt-2">
                            <x-icon-file-plus />
                            <span class="ml-1">{{ __('New') }}</span>
                        </x-button-inline>
                    </div>
                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead >
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Name') }}</x-th>
                                    <x-th>{{ __('Description') }}</x-th>
                                    <x-th>{{ __('Subcategories') }}</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    <x-th>{{ __('Show') }}</x-th>
                                    <x-th class="float-right">{{ __('Options') }}</x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $category->name }}</x-td>
                                        <x-td>{{ $category->description }}</x-td>
                                        <x-td>{{ $category->subcategory->count() }}</x-td>
                                        <x-td>{{ $category->product->count() }}</x-td>
                                        <x-td>
                                            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                <input type="checkbox" wire:click="setShow({{ $category->id }})" class="sr-only peer" @if($category->show) checked @endif >
                                                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                            </label>
                                        </x-td>
                                        <x-td class="float-right">
                                            <x-dropdown align="auto" width="48">
                                                <x-slot name="trigger">
                                                    <x-button-inline>
                                                        <x-icon-points class="-ml-2 -mr-2" />
                                                    </x-button-inline>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.category.edit', [{{$category->id}}])" class="flex items-center" style="cursor:pointer">
                                                        <x-icon-edit />
                                                        <span class="ml-2">{{ __('Edit') }}</span>
                                                    </x-dropdown-link>

                                                    <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.category.destroy', [{{$category->id}}])" class="flex items-center" style="cursor: pointer">
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
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
