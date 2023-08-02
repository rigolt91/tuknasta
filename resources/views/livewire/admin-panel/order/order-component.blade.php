<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        {{ __('Orders') }} ({{ $orders->count() }})

                        <div class="flex float-right -mt-2 -mr-2 sm:mr-0">
                            <div class="flex sm:mr-2">
                                <input wire:model="date" type="date" class="hidden w-full px-2 font-normal text-gray-500 border border-gray-200 rounded sm:block h-9 focus:border-green-500 focus:ring-green-500 focus:border-ring-500" autofocus />
                            </div>

                            <div class="hidden float-right w-32 mr-2 sm:block">
                                <select wire:model='order_status' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All status')}}</option>
                                    @foreach ($order_statuses as $order_status)
                                        <option value="{{ $order_status->id }}">{{ __($order_status->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="hidden float-right w-48 mr-2 sm:block">
                                <select wire:model='delivery_method' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All delivery methods')}}</option>
                                    @foreach ($delivery_methods as $delivery_method)
                                        <option value="{{ $delivery_method->id }}">{{ __($delivery_method->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex mr-2">
                                <input wire:model="search" type="search" class="w-32 px-2 font-normal border-gray-200 rounded rounded-r-none h-9 focus:border-green-500 focus:ring-green-500" autofocus placeholder="{{ __('Search') }}" />
                                <span class="p-1 bg-green-400 border border-l-0 border-gray-200 rounded-l-none rounded-r h-9">
                                    <svg fill="white" class="h-5 px-1 my-1 bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>

                            <svg wire:click="generatePDFOrders" wire:loading.attr='disabled' wire:loading.class='opacity-60' fill="currentColor" class="hidden p-1 text-green-600 border border-gray-300 rounded-md cursor-pointer sm:block bi h-9 bi-printer-fill hover:border-green-600 hover:shadow hover:text-green-800" viewBox="0 0 16 16">
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
                                    <x-th class="float-right">{{ __('Options') }}</x-th>
                                </x-tr>
                            </x-thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <x-tr wire:loading.class="opacity-60">
                                        <x-td>{{ ++$key }}</x-td>
                                        <x-td>{{ $order->number }}</x-td>
                                        <x-td>{{ __($order->orderStatus->name) }}</x-td>
                                        <x-td>{{ __($order->deliveryMethod->name) }}</x-td>
                                        <x-td>
                                            <div>{{ $order->contact}}</div>
                                            <div>{{ $order->dni }}</div>
                                        </x-td>
                                        <x-td>{{ $order->created_at }}</x-td>
                                        <x-td class="float-right">
                                            <div class="flex items-center my-5 sm:my-1">
                                                <x-button-inline wire:click="show({{ $order }})" wire:loading.attr="disabled" class="flex items-center mr-1 disabled:opacity-60">
                                                    <x-icon-eye />
                                                    <span class="hidden ml-2 sm:block">{{ __('Show') }}</span>
                                                </x-button-inline>

                                                <button wire:click="edit({{ $order }})" wire:loading.attr="disabled" class="flex disabled:opacity-60 items-center px-2 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 hover:scale-105 shadow-[0_4px_9px_-4px_#14a44d] hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)]" {{ $order->order_status_id==3 ? 'disabled' : '' }}>
                                                    <x-icon-edit />
                                                    <span class="hidden ml-2 sm:block">{{ __('Edit') }}</span>
                                                </button>

                                                @hasrole('administrator')
                                                    <x-button-danger wire:click="delete({{ $order }})" class="flex items-center ml-1 disabled:opacity-60">
                                                        <x-icon-trash />
                                                        <span class="hidden ml-2 sm:block">{{ __('Delete') }}</span>
                                                    </x-button-danger>
                                                @endhasrole
                                            </div>
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
