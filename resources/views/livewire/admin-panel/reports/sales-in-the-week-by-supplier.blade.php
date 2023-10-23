<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6" wire:loading.class='opacity-60 animation-pulse'>
        <div class="mx-4 sm:mx-2">
            <div class="pb-2 mb-4 font-bold border-b">
                {{__('Sales in the Week by Supplier')}}

                <div class="flex float-right text-gray-600">
                    <span class="ml-2">{{ $start_date }} / {{ $end_date }}</span>
                </div>
            </div>
        </div>

        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="relative overflow-x-auto">
                        <x-table>
                            <x-thead>
                                <x-tr>
                                    <x-th>Nro</x-th>
                                    <x-th>{{ __('Products') }}</x-th>
                                    <x-th>{{ __('Units') }}</x-th>
                                    <x-th>{{ __('Price') }}</x-th>
                                    <x-th>{{ __('Amount') }}</x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($branches as $key => $branch)
                                    <x-tr>
                                        <x-th>Nro</x-th>
                                        <x-th>{{ __('Products') }}</x-th>
                                        <x-th>{{ __('Units') }}</x-th>
                                        <x-th>{{ __('Price') }}</x-th>
                                        <x-th>{{ __('Amount') }}</x-th>
                                    </x-tr>
                                @endforeach
                            </tbody>
                        </x-table>
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
