<div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 sm:mx-2">
            <x-card class="bg-right bg-no-repeat bg-cover sm:bg-auto"
                style="background-image: url({{ asset('tukanasta.png') }})">
                <x-card-body class="flex">
                    <div class="sm:w-2/3">
                        <div class="w-full mb-6 text-gray-700">
                            <div class="mb-2 text-xl font-bold text-gray-800 border-b">
                                {{ __('Wholesaler') }}
                            </div>
                            {{ __('Do you need to make wholesale purchases for your business in Cuba? Tukanasta has a variety of wholesale options to always offer you the best and at the best price. Learn about all the offers available on the online platform and contact our sales team by email.') }}
                        </div>

                        <div class="p-3 bg-white rounded sm:p-0">
                            <form wire:submit.prevent='store' method="post">
                                <div class="relative mb-4 bg-transparent">
                                    <x-label for="subject" value="{{ __('Subject') }}" />
                                    <x-input wire:model.lazy='subject' class="block w-full mt-1" type="text" required
                                        autofocus autocomplete="subject" />
                                    <x-input-error for="subject" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input wire:model.lazy='email' class="block w-full mt-1" type="email" required
                                        autocomplete="email" />
                                    <x-input-error for="email" class="mt-2" />
                                </div>

                                <div class="relative">
                                    <x-label for="message" value="{{ __('Message') }}" />
                                    <x-textarea wire:model.lazy='message' class="block w-full mt-1" type="text"
                                        required autocomplete="message" />
                                    <x-input-error for="message" class="mt-2" />
                                </div>

                                <div class="flex items-center mt-4">
                                    <x-button type="submit" class="disabled:opacity-60" wire:loading.attr='disabled'>
                                        {{ __('Send Message') }}
                                        <x-icon-spin wire:loading wire:target="store" class="ml-1" />
                                    </x-button>

                                    @if (session()->has('message'))
                                        <div class="ml-4 alert alert-success">
                                            {{ __(session('message')) }}.
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card-body>
            </x-card>
        </div>
    </div>
</div>
