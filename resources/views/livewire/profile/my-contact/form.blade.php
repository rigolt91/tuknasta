<div>
    <div class="w-full sm:flex">
        <div class="w-full mt-2 mb-4 sm:mr-2">
            <div class="relative">
                <x-label for="name" :value="__('Name')" />
                <x-input wire:model.lazy='name' type="text" class="block w-full mt-1" :value="old('name', $name)" autofocus placeholder="Name" autocomplete="name" />
            </div>
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="w-full mt-2 mb-4 sm:ml-2">
            <div class="relative">
                <x-label for="last_name" :value="__('Last name')" />
                <x-input wire:model.lazy='last_name' type="text" class="block w-full mt-1" :value="old('last_name', $last_name)" placeholder="Last name" autocomplete="last_name" />
            </div>
            <x-input-error for="last_name" class="mt-2" />
        </div>
    </div>

    <div class="w-full sm:flex">
        <div class="w-full mt-2 mb-4 sm:mr-2">
            <div class="relative">
                <x-label for="email" :value="__('Email')" />
                <x-input wire:model.lazy='email' type="email" class="block w-full mt-1" :value="old('email', $email)" placeholder="Email" autocomplete="email" />
            </div>
            <x-input-error for="email" class="mt-2" />
        </div>

        <div class="w-full mt-2 mb-4 sm:ml-2">
            <div class="relative">
                <x-label for="phone" :value="__('Phone')" />
                <x-input wire:model.lazy='phone' type="text" class="block w-full mt-1" :value="old('phone', $phone)" placeholder="Phone number" autocomplete="phone" />
            </div>
            <x-input-error for="phone" class="mt-2" />
        </div>
    </div>


    <div class="w-full mt-2 mb-4">
        <div class="relative">
            <x-label for="dni" :value="__('DNI')" />
            <x-input wire:model.lazy='dni' type="text" class="block w-full mt-1" :value="old('dni', $dni)" placeholder="Identity card" autocomplete="dni" />
        </div>
        <x-input-error for="dni" class="mt-2" />
    </div>

    <div class="sm:flex">
        <div class="w-full mt-2 mb-4 sm:mr-2">
            <div class="relative">
                <x-label for="street" :value="__('Street')" />
                <x-input wire:model.lazy='street' type="text" class="block w-full mt-1" :value="old('street', $street)" placeholder="Name of the street" autocomplete="street" />
            </div>
            <x-input-error for="street" class="mt-2" />
        </div>

        <div class="w-full mt-2 mb-4 sm:ml-2">
            <div class="relative">
                <x-label for="number" :value="__('House number')" />
                <x-input wire:model.lazy='number' type="text" class="block w-full mt-1" :value="old('number', $number)" placeholder="House number" autocomplete="number" />
            </div>
            <x-input-error for="number" class="mt-2" />
        </div>
    </div>

    <div class="w-full mt-2 mb-4">
        <div class="relative">
            <x-label for="between_streets" :value="__('Address')" />
            <x-input wire:model.lazy='between_streets' type="text" class="block w-full mt-1" :value="old('between_streets', $between_streets)" placeholder="Address" autocomplete="between_streets" />
        </div>
        <x-input-error for="between_streets" class="mt-2" />
    </div>

    <div class="sm:flex">
        <div class="w-full mt-2 mb-4 mr-2">
            <div class="relative">
                <x-label for="province_id" :value="__('Province')" />
                <x-select wire:model='province_id'>
                    <option value="" selected disabled>{{ __('List of provinces') }}</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="province_id" class="mt-2" />
        </div>

        <div class="w-full mt-2 mb-4 sm:ml-2">
            <div class="relative">
                <x-label for="municipality_id" :value="__('Municipality')" />
                <x-select wire:model='municipality_id'>
                    <option value="" selected disabled>{{ __('List of municipalities') }}</option>
                    @foreach ($municipalities as $municipality)
                        <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="municipality_id" class="mt-2" />
        </div>
    </div>
</div>
