<div class="my-12">
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="mb-4 mx-2">
            @include('livewire.payment.steps.steps-bars-info')
        </div>

        <div class="sm:flex">
            <div class="sm:mx-2 sm:w-9/12">
                <x-card>
                    <x-card-header>
                        <span class="text-md text-gray-600 font-semibold ">{{ __('Personal Information') }}</span>
                    </x-card-header>
                    <x-card-body>
                        <div class="mt-4 mb-6">
                            <div class="relative">
                                <x-label for="email" :value="__('Your Email')" />
                                <x-input wire:model='email' type="text" class="mt-1 block w-full" disabled :value="old('email', $email)" placeholder="{{__('Email')}}" autocomplete="email" />
                            </div>
                            <x-input-error class="mt-2" for="email" />
                        </div>

                        <div class="border-b pt-1 pb-3 items-center">
                            <span class="text-md text-gray-600 font-semibold ">{{__('Receiver Information')}}</span>

                            <x-button-inline type="button" wire:click="$emit('openModal', 'profile.my-contact.my-contact')" class="items-center w-8 h-8 float-right text-green-800 hover:text-white">
                                <svg fill="currentColor" class="bi bi-plus-square -mx-3 h-6" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </x-button-inline>
                        </div>

                        <div class="mt-2">
                            @include('livewire.payment.component.contact')
                        </div>
                    </x-card-body>
                </x-card>
            </div>

            <div class="sm:mx-2 sm:w-3/12">
                <x-button-payment wire:click="paymentDelivery" class="mb-4 cursor-pointer">
                    {{ __('Payment') }}
                </x-button-payment>

                <div class="px-6 py-6 mb-4 shadow rounded-lg">
                    @include('livewire.payment.component.products')
                </div>

                @include('livewire.cart.component.total-cost')

                @include('livewire.cart.component.politics')

                <div class="-mt-4">
                    <x-button-return route="{{ route('dashboard') }}">
                        {{ __('Keep Buying') }}
                    </x-button-return>
                </div>
            </div>
        </div>
    </div>
</div>
