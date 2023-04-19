<div>
    <x-card>
        <x-card-header class="flex items-center">
            <div class="-mt-2 pb-2 text-lg font-bold text-gray-800">{{ __('Privacy Policy') }}</div>

            <button wire:click="$emit('closeModal')" type="button" class="float-right -mt-4 ml-auto -mx-1.5 text-gray-800 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-100 hover:text-green-900 inline-flex h-8 w-8"  aria-label="Close">
                <span class="sr-only">{{__('Cerrar')}}</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </x-card-header>
        <x-card-body>
            <p class="mb-4 text-gray-700 text-justify text-sm">
                {{__('You are required to have an account name and password for certain activities on this Web site.')}}
            </p>
            <p class="mb-4 text-gray-700 text-justify text-sm">
                {{__('The data provided by you is incorporated into our database, being used solely for registration authentication and processing the order.')}} <span class="font-bold uppercase text-green-700">Superbuy.cu</span> {{__('undertakes not to disclose the data to third parties and to use it only for exchange purposes between us and you. The data can be modified at any time you wish.')}}
            </p>
            <p class="mb-4 text-gray-700 text-justify text-sm">
                {{__('We may terminate or suspend your account name and password at any time without notice to you or any other person if we believe that you have breached our policies, terms and conditions. We are under no obligation to verify the current identity or authorization of any person using the account name and password to access and use the Website.')}}
            </p>
            <p class="mb-4 text-gray-700 text-justify text-sm">
                {{__('We have the right at any time to demand proof of the identity of any person requesting access to and use of the Website, and we may deny access if we are not satisfied with such proof. You are fully responsible for the security of your account name and password and for all uses and/or abuses.')}}
            </p>
            <p class="mb-4 text-gray-700 text-justify text-sm">
                {{__('You agree to notify us immediately of any unauthorized use of your account.')}} <span class="font-bold uppercase text-green-700">Superbuy.cu</span> {{__('assumes no responsibility, and will not be liable, for any damages arising from or related to your failure to maintain the security of your password.')}}
            </p>
        </x-card-body>
    </x-card>
</div>
