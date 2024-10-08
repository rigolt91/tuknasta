<div>
    <x-card>
        <x-card-header  class="bg-green-600 -m-6">
            <div class="py-2 mx-4 text-lg text-white font-bold flex items-center">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mx-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <span>{{ __('Information') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Cerrar')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body class="mt-6">
            {{ __($message) }}
        </x-card-body>
    </x-card>
</div>
