<div>
    <x-card>
        <x-card-header  class="-m-6 bg-green-700">
            <div class="flex items-center py-3 mx-4 text-lg font-bold text-white">
                <svg fill="white" class="h-6 bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <span class="ml-2">{{ __('Search Order') }}</span>

                <button wire:click="$emit('closeModal')" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body>
            <form action="{{ route('admin-panel.orders') }}" method="get">
                <div class="pt-8">
                    <div class="mt-2 mb-4">
                        <div class="relative">
                            <x-input name="search" type="text" class="block w-full mt-1" value="{{ old('search') }}" placeholder="{{__('Search...')}}" autofocus autocomplete="search" />
                        </div>
                        <x-input-error for="name" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">
                        {{ __('Accept') }}
                    </x-button>
                </div>
            </form>
        </x-card-body>
    </x-card>
</div>
