<div>
    <x-card>
        <x-card-header  class="bg-red-700 -m-6">
            <div class="py-3 mx-4 text-lg text-white font-bold flex">
                <x-icon-trash class="h-6 w-6" />
                <span class="ml-2">{{ __('Delete Product') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body class="mx-2">
            <div class="mt-8">
                <form wire:submit.prevent='destroy' method="post">
                    @csrf

                    <div class="mb-4">
                        {{ __('Are you sure you want to delete this product?') }}
                    </div>

                    <div class="flex items-center justify-end -mb-4">
                        <x-button-danger wire:click="$emit('closeModal')" wire:loading.attr='disabled' type="button">
                            {{ __('Cancel') }}
                        </x-button-danger>

                        <x-button type="submit" wire:loading.attr="disabled" class="disabled:opacity-60 ml-2">
                            {{ __('Accept') }}
                            <x-icon-spin wire:loading wire:target="destroy" class="ml-1" />
                        </x-button>
                    </div>
                </form>
            </div>
        </x-card-body>
    </x-card>
</div>
