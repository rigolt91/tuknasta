<div>
    <x-card>
        <x-card-header class="flex items-center">
            <div class="-mt-2 pb-2 text-lg font-bold text-gray-800">{{ __('Return Policy') }}</div>

            <button wire:click="$emit('closeModal')" type="button" class="float-right -mt-4 ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                <span class="sr-only">{{__('Cerrar')}}</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </x-card-header>
        <x-card-body>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quia laborum praesentium animi perspiciatis velit iure ad? Temporibus explicabo modi aliquid repudiandae ad ducimus excepturi reprehenderit adipisci illum dicta. Tempore, expedita?
        </x-card-body>
    </x-card>
</div>
