<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 sm:mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('List of Categories') }}

                        @hasrole('administrator')
                            <x-button-inline wire:click="create" class="flex float-right -mt-2">
                                <x-icon-file-plus />
                                <span class="ml-1">{{ __('Add') }}</span>
                            </x-button-inline>
                        @endhasrole
                    </div>
                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead>
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Photo') }}</x-th>
                                    <x-th>{{ __('Name') }}</x-th>
                                    <x-th>{{ __('Description') }}</x-th>
                                    <x-th>{{ __('Subcategories') }}</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    @hasrole('administrator')
                                        <x-th>{{ __('Show') }}</x-th>
                                        <x-th class="float-right">{{ __('Options') }}</x-th>
                                    @endhasrole
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>
                                            <img src="{{ Storage::url($category->image) }}"
                                                class="flex items-center justify-center text-xs w-12 h-12 bg-green-100 border border-green-400 rounded"
                                                alt="img">
                                        </x-td>
                                        <x-td>{{ $category->name }}</x-td>
                                        <x-td>{{ $category->description }}</x-td>
                                        <x-td>{{ $category->subcategory->count() }}</x-td>
                                        <x-td>{{ $category->product->count() }}</x-td>
                                        @hasrole('administrator')
                                            <x-td>
                                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                    <input type="checkbox" wire:click="setShow({{ $category }})"
                                                        wire:loading.attr="disabled" class="sr-only peer"
                                                        @if ($category->show) checked @endif>
                                                    <div
                                                        class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600">
                                                    </div>
                                                </label>
                                            </x-td>
                                            <x-td class="flex float-right">
                                                <x-button wire:click="edit({{ $category }})"
                                                    wire:loading.attr="disabled"
                                                    class="flex items-center mx-1 disabled:opacity-60">
                                                    <x-icon-edit />
                                                    <span class="hidden sm:ml-2 sm:block">{{ __('Edit') }}</span>
                                                </x-button>

                                                <x-button-danger wire:click="delete({{ $category }})"
                                                    wire:loading.attr="disabled"
                                                    class="flex items-center disabled:opacity-60">
                                                    <x-icon-trash />
                                                    <span class="hidden sm:ml-2 sm:block">{{ __('Delete') }}</span>
                                                </x-button-danger>
                                            </x-td>
                                        @endhasrole
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
