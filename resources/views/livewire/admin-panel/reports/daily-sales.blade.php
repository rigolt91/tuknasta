<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6" wire:loading.class='opacity-60 animation-pulse'>
        <div class="mx-2">
            <div class="pb-2 mb-4 font-bold border-b">
                {{__('Daily Sales')}}

                <div class="flex float-right text-gray-600">
                    {{ __('Date') }}: <span class="ml-2">{{ $date }}</span>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <div class="flex">
                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.orders', ['date' => $date])
                </div>

                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.products', ['date' => $date])
                </div>

                <div class="w-full mx-2">
                    @livewire('admin-panel.reports.components.profits', ['date' => $date])
                </div>
            </div>
        </div>

        @livewire('admin-panel.reports.components.graphics', ['date' => $date])

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
                                @foreach ($products as $key => $product)
                                    <x-tr>
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $product->name }}</x-td>
                                        <x-td>{{ $product->purchasedUnits($date) }}</x-td>
                                        <x-td>$ {{ number_format($product->userPurchasedProduct->pluck('price')->first(), 2) }}</x-td>
                                        <x-td>$ {{ number_format($product->purchasedAmount($date), 2) }}</x-td>
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
