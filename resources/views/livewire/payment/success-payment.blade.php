<div>
    <x-card>
        <x-card-header  class="-m-6 bg-green-700">
            <div class="flex py-2 mx-4 text-lg font-bold text-white">
                <span class="ml-2">{{ __('Success') }}</span>

                <button wire:click="close" type="button" class="float-right ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                    <span class="sr-only">{{__('Close')}}</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </x-card-header>

        <x-card-body class="mt-6">
            <div class="text-lg font-bold text-gray-700">
                {{__("The payment was completed satisfactorily.")}}
            </div>

            <div class="text-gray-600 text-md">
                {{__("Thank you for shopping at Superbuy, an email has been sent to you and the recipient with the details of your purchase.")}}
            </div>

            <div>
                {{ $message }}
            </div>
        </x-card-body>
    </x-card>
</div>
