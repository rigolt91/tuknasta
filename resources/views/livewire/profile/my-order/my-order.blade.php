<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold leading-tight text-gray-800 text-md">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-2">
            <x-card>
                <x-card-header>
                    <span class="hidden float-left mr-2 font-semibold text-gray-700 text-md sm:block">Orders ({{ $user_orders->count() }})</span>
                    <div class="flex justify-end w-full pb-2">
                        <div class="flex items-center w-full shadow">
                            <input wire:model="search" type="search" class="w-full px-2 font-normal border-green-400 rounded rounded-r-none h-9 focus:border-white focus:ring-green-500" autofocus placeholder="{{ __('Search order...') }}" />
                            <span class="p-1 bg-green-400 border border-l-0 border-green-400 rounded-l-none rounded-r h-9">
                                <svg fill="white" class="h-5 px-1 my-1 bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </x-card-header>

                <x-card-body>
                    @foreach ($user_orders as $key => $order)
                        <x-table class="mb-4 border">
                            <x-thead>
                                <x-tr class="bg-green-200">
                                    <x-th>{{__('Order Number')}}</x-th>
                                    <x-td class="font-bold">{{ $order->number }}</x-td>
                                </x-tr>
                                <x-tr>
                                    <x-th>{{__('Status')}}</x-th>
                                    <x-td>{{ $order->orderStatus->name }}</x-td>
                                </x-tr>
                                <x-tr>
                                    <x-th>{{__('Products')}} ({{ $order->totalProducts() }})</x-th>
                                    <x-td class="text-left">
                                        @foreach ($order->userPurchasedProduct as $key => $product)
                                            <div class="w-full py-1 border-none sm:w-72">
                                                <span class="mr-2">{{ ++$key }}-</span>
                                                <span class="mr-2">{{ $product->product->name }} ({{ $product->units }})</span>
                                                <span class="float-right ml-2">${{ number_format($product->units * $product->price, 2) }}</span>
                                            </div>
                                        @endforeach

                                        <div class="w-full text-left border-t sm:w-72">
                                            <span class="font-semibold">{{__('Total Cost:')}}</span>
                                            <span class="float-right font-semibold">${{ number_format($order->totalCost(), 2) }}</span>
                                        </div>
                                    </x-td>
                                </x-tr>
                                <x-tr>
                                    <x-th>{{__('Delivery Method')}}</x-th>
                                    <x-td>{{ $order->deliveryMethod->name }}</x-td>
                                </x-tr>
                                <x-tr>
                                    <x-th>{{__('Date')}}</x-th>
                                    <x-td>{{ $order->created_at }}</x-td>
                                </x-tr>
                            </x-thead>
                        </x-table>
                    @endforeach

                    <div class="mt-4">{{ $user_orders->links() }}</div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
