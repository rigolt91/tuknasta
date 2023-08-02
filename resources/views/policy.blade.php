<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose mb-4">
                <p class="mb-4 pb-2 text-lg font-bold text-gray-800">{{ __('Privacy Policy') }}</p>

                <p class="mb-4 text-gray-700 text-justify text-sm">
                    {{ __('You are required to have an account name and password for certain activities on this Web site.') }}
                </p>
                <p class="mb-4 text-gray-700 text-justify text-sm">
                    {{ __('The data provided by you is incorporated into our database, being used solely for registration authentication and processing the order.') }}
                    <span class="font-bold uppercase text-green-700">Tukanasta</span>
                    {{ __('undertakes not to disclose the data to third parties and to use it only for exchange purposes between us and you. The data can be modified at any time you wish.') }}
                </p>
                <p class="mb-4 text-gray-700 text-justify text-sm">
                    {{ __('We may terminate or suspend your account name and password at any time without notice to you or any other person if we believe that you have breached our policies, terms and conditions. We are under no obligation to verify the current identity or authorization of any person using the account name and password to access and use the Website.') }}
                </p>
                <p class="mb-4 text-gray-700 text-justify text-sm">
                    {{ __('We have the right at any time to demand proof of the identity of any person requesting access to and use of the Website, and we may deny access if we are not satisfied with such proof. You are fully responsible for the security of your account name and password and for all uses and/or abuses.') }}
                </p>
                <p class="mb-4 text-gray-700 text-justify text-sm">
                    {{ __('You agree to notify us immediately of any unauthorized use of your account.') }} <span
                        class="font-bold uppercase text-green-700">Tukanasta</span>
                    {{ __('assumes no responsibility, and will not be liable, for any damages arising from or related to your failure to maintain the security of your password.') }}
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
