<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 sm:mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('List of Suppliers') }}

                        @hasrole('administrator')
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
                                    <x-th>{{ __('Phone') }}</x-th>
                                    <x-th>{{ __('Email') }}</x-th>
                                    <x-th>{{ __('Contract Number') }}</x-th>
                                    <x-th>{{ __('Person Contact') }}</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    <x-th>{{ __('Supplier') }}</x-th>
                                    <x-th></x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($branches as $key => $branch)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $branch->name }}</x-td>
                                        <x-td>{{ $branch->phone }}</x-td>
                                        <x-td>{{ $branch->email }}</x-td>
                                        <x-td>{{ $branch->contract_number }}</x-td>
                                        <x-td>{{ $branch->person_contact }}</x-td>
                                        <x-td>{{ $branch->product->count() }}</x-td>
                                        <x-td>
                                            @foreach ($branches as $bran)
                                                @if ($bran->id == $branch->sub_branch)
                                                    {{ $bran->name }}
                                                @endif
                                            @endforeach
                                        </x-td>
                                        @hasrole('administrator')
                                            <x-td class="flex float-right">
                                                <x-button wire:click="edit({{ $branch }})" wire:loading.attr="disabled" class="flex items-center mx-1 disabled:opacity-60">
                                                    <x-icon-edit />
                                                    <span class="hidden sm:ml-2 sm:block">{{ __('Edit') }}</span>
                                                </x-button>

                                                <x-button-danger wire:click="delete({{ $branch }})" wire:loading.attr="disabled" class="flex items-center disabled:opacity-60">
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
                        {{ $branches->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
