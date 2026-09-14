<div class="py-6">
    <x-slot name="header">
        @livewire('admin-panel.nav-panel-component')
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <form wire:submit.prevent='store' method="post">
            @csrf
            <div class="sm:grid sm:grid-cols-2">
                <div class="mx-2">
                    <x-card>
                        <x-card-body>
                            <div>
                                <div class="text-gray-700 text-md font-bold border-b mb-4">
                                    {{ __('Site Information') }}
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="email" :value="__('Email')" />
                                        <x-input wire:model.lazy='email' type="text" class="mt-1 block w-full"
                                            :value="old('email', $email)" placeholder="{{ __('Email') }}" autofocus
                                            autocomplete="email" />
                                    </div>
                                    <x-input-error for="email" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="phone" :value="__('Phone')" />
                                        <x-input wire:model.lazy='phone' type="text" class="mt-1 block w-full"
                                            :value="old('phone', $phone)" placeholder="{{ __('Phone') }}" autofocus
                                            autocomplete="phone" />
                                    </div>
                                    <x-input-error for="phone" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="address" :value="__('Address')" />
                                        <x-input wire:model.lazy='address' type="text" class="mt-1 block w-full"
                                            :value="old('address', $address)" placeholder="{{ __('Address') }}" autofocus
                                            autocomplete="address" />
                                    </div>
                                    <x-input-error for="address" class="mt-2" />
                                </div>
                            </div>
                        </x-card-body>
                    </x-card>
                </div>

                <div class="mx-2">
                    <x-card>
                        <x-card-body>
                            <div>
                                <div class="text-gray-700 text-md font-bold border-b mb-4">
                                    {{ __('Social Links') }}
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="facebook" :value="__('Facebook')" />
                                        <x-input wire:model.lazy='facebook' type="text" class="mt-1 block w-full"
                                            :value="old('facebook', $facebook)" placeholder="{{ __('Facebook') }}" autofocus
                                            autocomplete="facebook" />
                                    </div>
                                    <x-input-error for="facebook" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="instagram" :value="__('Instagram')" />
                                        <x-input wire:model.lazy='instagram' type="text" class="mt-1 block w-full"
                                            :value="old('instagram', $instagram)" placeholder="{{ __('Instagram') }}" autofocus
                                            autocomplete="instagram" />
                                    </div>
                                    <x-input-error for="instagram" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="twitter" :value="__('Twitter')" />
                                        <x-input wire:model.lazy='twitter' type="text" class="mt-1 block w-full"
                                            :value="old('twitter', $instagram)" placeholder="{{ __('Twitter') }}" autofocus
                                            autocomplete="twitter" />
                                    </div>
                                    <x-input-error for="twitter" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="linkedin" :value="__('LinkedIn')" />
                                        <x-input wire:model.lazy='linkedin' type="text" class="mt-1 block w-full"
                                            :value="old('linkedin', $instagram)" placeholder="{{ __('LinkedIn') }}" autofocus
                                            autocomplete="linkedin" />
                                    </div>
                                    <x-input-error for="linkedin" class="mt-2" />
                                </div>

                                <div class="mt-2 mb-4">
                                    <div class="relative">
                                        <x-label for="google" :value="__('Google')" />
                                        <x-input wire:model.lazy='google' type="text" class="mt-1 block w-full"
                                            :value="old('google', $instagram)" placeholder="{{ __('Google') }}" autofocus
                                            autocomplete="google" />
                                    </div>
                                    <x-input-error for="google" class="mt-2" />
                                </div>

                                <div class="flex justify-end -mb-4">
                                    <x-button type="submit" wire:loading.attr="disabled" class="ml-2 disabled:opacity-60">
                                        {{ __('Save') }}
                                        <x-icon-spin wire:loading wire:target="store" class="ml-1" />
                                    </x-button>
                                </div>
                            </div>
                        </x-card-body>
                    </x-card>
                </div>
            </div>
        </form>
    </div>
</div>
