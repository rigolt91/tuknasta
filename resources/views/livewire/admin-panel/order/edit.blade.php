<div>
    <x-card>
        <x-card-header  class="-m-6 bg-green-700">
            <div class="flex py-3 mx-4 text-lg font-bold text-white">
                <x-icon-edit class="w-6 h-6" />
                <span class="ml-2">{{ __('Edit Order') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body class="mx-2 mt-8">
            <form wire:submit.prevent='update' method="post">
                @csrf
                <div class="mt-2 mb-4">
                    <div class="relative">
                        <x-label for="order_status" :value="__('Order Status')" />
                        <x-select wire:model='order_status'>
                            @foreach ($order_statuses as $order_status)
                                <option value="{{ $order_status->id }}">{{ __($order_status->name) }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <x-input-error for="order_status" class="mt-2" />
                </div>

                <div class="flex justify-end -mb-4">
                    <x-button type="submit" wire:loading.attr='disabled' class="ml-2 disabled:opacity-60" >
                        {{ __('Update') }}
                        <x-icon-spin wire:loading wire:target="update" class="ml-1" />
                    </x-button>
                </div>
            </form>
        </x-card-body>
    </x-card>
</div>
