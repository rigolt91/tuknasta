<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('List of Subcategories') }}

                        @hasrole(['administrator', 'editor'])
                            <x-button-inline wire:click="create" class="flex float-right -mt-2">
                                <x-icon-file-plus />
                                <span class="ml-1">{{ __('Add') }}</span>
                            </x-button-inline>
                        @endhasrole
                    </div>

                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead >
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Name') }}</x-th>
                                    <x-th>{{ __('Category') }}</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    @hasrole(['administrator', 'editor'])
                                        <x-th>{{ __('Show') }}</x-th>
                                        <x-th class="float-right">{{ __('Options') }}</x-th>
                                    @endhasrole
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($subcategories as $key => $subcategory)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $subcategory->name }}</x-td>
                                        <x-td>{{ $subcategory->category->name }}</x-td>
                                        <x-td>{{ $subcategory->product->count() }}</x-td>
                                        @hasrole(['administrator', 'editor'])
                                            <x-td>
                                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                                    <input type="checkbox" wire:click="setShow({{ $subcategory->id }})" wire:loading.attr="disabled" class="sr-only peer disabled:opacity-60" @if($subcategory->show) checked @endif >
                                                    <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                                </label>
                                            </x-td>
                                            <x-td class="flex float-right">
                                                <x-button wire:click="edit({{ $subcategory }})" wire:loading.attr="disabled" class="flex items-center mr-1 disabled:opacity-60">
                                                    <x-icon-edit />
                                                    <span class="hidden ml-2 sm:block">{{ __('Edit') }}</span>
                                                </x-button>

                                                <x-button-danger wire:click="delete({{ $subcategory }})" wire:loading.attr="disabled" class="flex items-center disabled:opacity-60">
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
                        {{ $subcategories->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
