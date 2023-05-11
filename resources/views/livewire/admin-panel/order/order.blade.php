<div class="py-12">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('Orders') }} ({{ $orders->count() }})

                        <div class="flex float-right -mt-2">
                            <div class="flex mr-2">
                                <input wire:model="date" type="date" class="hidden w-full px-2 font-normal text-gray-500 border border-gray-200 rounded sm:block h-9 focus:border-green-500 focus:ring-green-500 focus:border-ring-500" autofocus />
                            </div>

                            <div class="hidden float-right w-32 mr-2 sm:block">
                                <select wire:model='order_status' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All status')}}</option>
                                    @foreach ($order_statuses as $order_status)
                                        <option value="{{ $order_status->id }}">{{ $order_status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="hidden float-right w-48 mr-2 sm:block">
                                <select wire:model='delivery_method' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All delivery methods')}}</option>
                                    @foreach ($delivery_methods as $delivery_method)
                                        <option value="{{ $delivery_method->id }}">{{ $delivery_method->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex mr-2">
                                <input wire:model="search" type="search" class="w-32 px-2 font-normal border-gray-200 rounded rounded-r-none h-9 focus:border-green-500 focus:ring-green-500" autofocus placeholder="{{ __('Search...') }}" />
                                <span class="p-1 bg-green-400 border border-l-0 border-gray-200 rounded-l-none rounded-r h-9">
                                    <svg fill="white" class="h-5 px-1 my-1 bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <svg wire:click="generatePDFOrders" wire:loading.attr='disabled' wire:loading.class='opacity-60' fill="currentColor" class="p-1 text-green-600 border border-gray-300 rounded-md cursor-pointer bi h-9 bi-printer-fill hover:border-green-600 hover:shadow hover:text-green-800" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                        <x-table class="w-full">
                            <x-thead >
                                <x-tr>
                                    <x-th>#</x-th>
                                    <x-th>{{ __('Number') }}</x-th>
                                    <x-th>{{ __('Status') }}</x-th>
                                    <x-th>{{ __('Delivery Method') }}</x-th>
                                    <x-th>{{ __('Receive the Order') }}</x-th>
                                    <x-th>{{ __('Date') }}</x-th>
                                    <x-th></x-th>
                                    <x-th class="float-right">{{ __('Options') }}</x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $order->number }}</x-td>
                                        <x-td>{{ $order->orderStatus->name }}</x-td>
                                        <x-td>{{ $order->deliveryMethod->name }}</x-td>
                                        <x-td>
                                            <div>{{ $order->contact_name.' '.$order->contact_last_name }}</div>
                                            <div>{{ $order->contact_dni }}</div>
                                        </x-td>
                                        <x-td>{{ $order->created_at }}</x-td>
                                        <x-td>
                                            <svg wire:click="generatePDF({{ $order->id }})" wire:loading.attr='disabled' wire:loading.class='opacity-60' fill="currentColor" class="p-1 text-green-600 border rounded-md cursor-pointer bi h-9 bi-printer-fill hover:border-green-600 hover:shadow hover:text-green-800" viewBox="0 0 16 16">
                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                            </svg>
                                        </x-td>
                                        <x-td class="float-right">
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <x-button-inline class="mt-3 sm:mt-1">
                                                        <x-icon-points class="-ml-2 -mr-2"/>
                                                    </x-button-inline>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.order.show', [{{$order->id}}])" class="flex items-center cursor-pointer">
                                                        <x-icon-eye />
                                                        <span class="ml-2">{{ __('Show') }}</span>
                                                    </x-dropdown-link>

                                                    <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.order.edit', [{{$order->id}}])" class="flex items-center" style="cursor:pointer">
                                                        <x-icon-edit />
                                                        <span class="ml-2">{{ __('Edit') }}</span>
                                                    </x-dropdown-link>

                                                    <x-dropdown-link wire:click="$emit('openModal', 'admin-panel.order.destroy', [{{$order->id}}])" class="flex items-center" style="cursor: pointer">
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
                        {{ $orders->links() }}
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
