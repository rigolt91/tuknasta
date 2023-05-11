<div class="my-12">
    <x-slot name="header">
        <h2 class="font-semibold leading-tight text-gray-800 text-md">
            {{ __('Delivery') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 mb-4 sm:mx-2">
            @include('livewire.payment.steps.steps-bars-delivery')
        </div>
        <div x-data="{open: true}">
            <div x-show="open" class="flex items-center justify-center px-2 py-1 mx-4 mb-4 font-medium text-green-700 bg-green-100 border border-green-300 shadow sm:mx-2 sm:rounded-md ">
                <div slot="avatar">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mx-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="flex-initial max-w-full text-lg font-normal">
                    <div class="py-1">{{__('Delivery information')}}
                        <div class="text-sm font-base">{{__('The home delivery service is only available for the province of Las Tunas.')}}</div>
                    </div>
                </div>
                <div class="flex flex-row-reverse flex-auto">
                    <div @click="open = !open">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-2 rounded-full cursor-pointer feather feather-x hover:text-yellow-400">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="sm:flex">
            <div class="mx-4 sm:mx-2 sm:w-9/12">
                <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                    <x-card-body>
                        <div class="items-center pt-1 pb-3 border-b">
                            <span class="font-semibold text-gray-600 text-md ">{{__('Receiver Information')}}</span>

                            <x-button-inline wire:click="$emit('openModal', 'profile.my-contact.my-contact')" class="items-center float-right w-8 h-8 text-green-800 hover:text-white">
                                <svg fill="currentColor" class="h-6 -mx-3 bi bi-plus-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </x-button-inline>
                        </div>

                        <div class="mt-2">
                            @include('livewire.payment.component.contact')
                        </div>
                    </x-card-body>
                </div>

                <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                    @include('livewire.payment.component.products')
                </div>
            </div>

            <div class="mx-4 sm:mx-2 sm:w-3/12">
                <x-button-payment wire:click="paymentConfirm" class="mb-4 cursor-pointer">
                    {{ __('Payment') }}
                </x-button-payment>

                @include('livewire.cart.component.total-cost')

                @csrf
                <div class="px-4 py-4 mb-4 shadow sm:rounded-lg sm:px-6">
                    <x-card-header class="font-bold">{{ __('Method of Delivery') }}</x-card-header>

                    <x-card-body>
                        @foreach ($delivery_methods as $method)
                            <div class="relative mt-4" wire:loading.class="duration-300 opacity-60">
                                <label for="{{ $method->id }}" class="flex items-center cursor-pointer">
                                    <input wire:loading.attr="disabled" wire:click="deliveryMethod({{$method->id}})" id="{{ $method->id }}" name="method_delivery" type="checkbox" @if($method->id==$delivery_method) checked @endif class="p-2 text-green-600 border border-green-500 rounded shadow-sm cursor-pointer focus:ring-green-500" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __($method->name) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </x-card-body>
                </div>

                @include('livewire.cart.component.politics')

                <div class="-mt-4">
                    <x-button-return route="{{ route('payment.payment') }}">
                        {{ __('Personal Information') }}
                    </x-button-return>
                </div>
            </div>
        </div>
    </div>
</div>
