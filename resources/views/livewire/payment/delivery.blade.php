<div class="my-12">
    <x-slot name="header">
        <h2 class="font-semibold text-md text-gray-800 leading-tight">
            {{ __('Delivery') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="mb-4 mx-2">
            @include('livewire.payment.steps.steps-bars-delivery')
        </div>

        <div x-data="{open: true}">
            <div x-show="open" class="flex justify-center items-center mb-4 mx-2 font-medium py-1 px-2 rounded-md shadow text-green-700 bg-green-100 border border-green-300 ">
                <div slot="avatar">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mx-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="text-lg font-normal max-w-full flex-initial">
                    <div class="py-1">{{__('Delivery information')}}
                        <div class="text-sm font-base">{{__('The home delivery service is only available for the province of Las Tunas.')}}</div>
                    </div>
                </div>
                <div class="flex flex-auto flex-row-reverse">
                    <div @click="open = !open">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-yellow-400 rounded-full w-5 h-5 ml-2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="sm:flex">
            <div class="sm:mx-2 sm:w-9/12">
                <div class="px-6 py-6 mb-4 shadow rounded-lg">
                    <x-card-body>
                        <div class="border-b pt-1 pb-3 items-center">
                            <span class="text-md text-gray-600 font-semibold ">{{__('Receiver Information')}}</span>

                            <x-button-inline wire:click="$emit('openModal', 'profile.my-contact.my-contact')" class="items-center w-8 h-8 float-right text-green-800 hover:text-white">
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
                </div>

                <div class="px-6 py-6 mb-4 shadow rounded-lg">
                    @include('livewire.payment.component.products')
                </div>
            </div>

            <div class="sm:mx-2 sm:w-3/12">
                <x-button-payment wire:click="paymentConfirm" class="mb-4 cursor-pointer">
                    {{ __('Payment') }}
                </x-button-payment>

                @include('livewire.cart.component.total-cost')

                @csrf
                <div class="px-6 py-4 mb-4 shadow rounded-lg">
                    <x-card-header class="font-bold">{{ __('Method of Delivery') }}</x-card-header>

                    <x-card-body>
                        @foreach ($delivery_methods as $method)
                            <div class="mt-4 relative" wire:loading.class="opacity-60 duration-300">
                                <label for="{{ $method->id }}" class="flex items-center cursor-pointer">
                                    <input wire:loading.attr="disabled" wire:click="deliveryMethod({{$method->id}})" id="{{ $method->id }}" name="method_delivery" type="checkbox" @if($method->id==$delivery_method) checked @endif class="rounded border border-green-500 p-2 text-green-600 shadow-sm focus:ring-green-500 cursor-pointer" />
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
