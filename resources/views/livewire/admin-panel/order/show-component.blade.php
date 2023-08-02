<div>
    <x-card>
        <x-card-header class="border-b">
            <div class="pb-1 text-lg text-gray-700 font-bold flex items-center">
                <x-icon-edit class="h-6 w-6" />
                <span class="ml-2">{{ __('Order Details') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body>
            <div class="mt-4">
                <x-table class="mb-4 border">
                    <x-thead>
                        <x-tr class="bg-green-200">
                            <x-th>{{__('Order Number')}}</x-th>
                            <x-td class="font-bold">{{ $number }}</x-td>
                        </x-tr>
                        <x-tr>
                            <x-th>{{__('Status')}}</x-th>
                            <x-td>{{ __($status) }}</x-td>
                        </x-tr>
                        <x-tr>
                            <x-th>{{__('Products')}} ({{ $total_products }})</x-th>
                            <x-td class="text-left">
                                @foreach ($products as $key => $product)
                                    <div class="w-full py-1 border-none">
                                        <span class="mr-2">{{ ++$key }}-</span>
                                        <span class="mr-2">{{ $product->product->name }} ({{ $product->units }})</span>
                                        <span class="float-right ml-2">${{ number_format($product->units * $product->price, 2) }}</span>
                                    </div>
                                @endforeach

                                <div class="w-full text-left border-t">
                                    <span class="font-semibold">{{__('Total Cost')}}:</span>
                                    <span class="float-right font-semibold">${{ number_format($total_cost, 2) }}</span>
                                </div>
                            </x-td>
                        </x-tr>
                        <x-tr>
                            <x-th>{{__('Delivery Method')}}</x-th>
                            <x-td>{{ __($delivery_method) }}</x-td>
                        </x-tr>
                        <x-tr>
                            <x-th>{{__('Date')}}</x-th>
                            <x-td>{{ $created_at }}</x-td>
                        </x-tr>
                        <x-tr>
                            <x-th>{{__('Receive')}}</x-th>
                            <x-td>
                                <div class="py-1">
                                    <span class="font-semibold">{{__('Name')}}:</span> {{ $contact->name.' '.$contact->last_name }}
                                </div>
                                <div class="py-1">
                                    <span class="font-semibold">{{__('DNI')}}:</span> {{ $contact->dni }}
                                </div>
                                <div class="py-1 lowercase">
                                    <span class="font-semibold uppercase">{{__('Email')}}:</span> {{ $contact->email }}
                                </div>
                                <div class="py-1">
                                    <span class="font-semibold">{{__('Phone')}}:</span> {{ $contact->phone }}
                                </div>
                                <div class="py-1">
                                    <span class="font-semibold">{{__('Address')}}:</span> {{ $contact->street.' #'.$contact->number.', '.$contact->between_streets.', '.$contact->municipality->name.', '.$contact->province->name}}
                                </div>
                            </x-td>
                        </x-tr>
                    </x-thead>
                </x-table>

                <div class="pb-4">
                    <x-button wire:click="generatePDF" wire:loading.attr='disabled' class="flex items-center float-right disabled:opacity-60">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        <span class="ml-1">{{__('Print')}}</span>
                        <x-icon-spin wire:loading wire:target="generatePDF" class="ml-1" />
                    </x-button>
                </div>
            </div>
        </x-card-body>
    </x-card>
</div>
