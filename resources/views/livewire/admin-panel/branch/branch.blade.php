<div class="py-12">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 -mt-2 mb-2 border-b border-green-300 font-bold">
                        {{ __('List of branches') }}

                        <x-button-inline wire:click="$emit('openModal', 'admin-panel.branch.create')" class="float-right -mt-2 flex">
                            <x-icon-file-plus />
                            <span class="ml-1">{{ __('New') }}</span>
                        </x-button-inline>
                    </div>

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
                                <x-th class="float-right">{{ __('Options') }}</x-th>
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
                                    <x-td class="float-right">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <x-button-inline>
                                                    <x-icon-points class="-ml-2 -mr-2" />
                                                </x-button-inline>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.branch.edit', [{{$branch->id}}])" class="flex items-center" style="cursor:pointer">
                                                    <x-icon-edit />
                                                    <span class="ml-2">{{ __('Edit') }}</span>
                                                </x-dropdown-link>

                                                <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.branch.destroy', [{{$branch->id}}])" class="flex items-center" style="cursor: pointer">
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
                        {{ $branches->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
