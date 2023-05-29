<div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-body>
                    <div class="pb-2 mb-2 -mt-2 font-bold border-b border-green-300">
                        <span>{{ __('Orders') }} ({{ $orders->count() }})</span>

                        <div class="flex float-right -mt-2">
                            <div class="hidden mr-2 sm:flex sm:display">
                                <input wire:model="date" type="date" class="w-full px-2 font-normal text-gray-500 border border-gray-200 rounded h-9 focus:border-green-500 focus:ring-green-500 focus:border-ring-500" autofocus />
                            </div>

                            <div class="hidden float-right mr-2 w-36 sm:block">
                                <select wire:model='order_status' class="peer font-normal h-9 w-full rounded border border-solid border-gray-200 bg-white cursor-pointer text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-0 px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:placeholder:opacity-100">
                                    <option value="" selected>{{__('All status')}}</option>
                                    @foreach ($order_statuses as $order_status)
                                        <option value="{{ $order_status->id }}">{{ __($order_status->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex">
                                <input wire:model="search" type="search" class="w-32 px-2 font-normal border-gray-200 rounded rounded-r-none h-9 focus:border-green-500 focus:ring-green-500" autofocus placeholder="{{ __('Search') }}..." />
                                <span class="p-1 bg-green-400 border border-l-0 border-gray-200 rounded-l-none rounded-r h-9">
                                    <svg fill="white" class="h-5 px-1 my-1 bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                            </div>
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
                                            <div>{{ $order->contact_name.' '.$order->contact_last_name }}</div>
                                            <div>{{ $order->contact_dni }}</div>
                                        </x-td>
                                        <x-td>{{ $order->created_at }}</x-td>
                                        <x-td class="float-right">
                                            <x-button wire:click="$emit('openModal', 'admin-panel.order.show', [{{$order->id}}])" wire:loading.attr="disabled" type="button" class="flex items-center cursor-pointer disabled:opacity-60">
                                                <x-icon-eye />
                                                <span class="hidden ml-1 sm:block">{{ __('Show') }}</span>
                                            </x-button>
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
