<div class="pt-8">
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="name" :value="__('Name')" />
            <x-input wire:model.lazy='name' type="text" class="block w-full mt-1" :value="old('name', $name)" placeholder="{{__('Branch name')}}" autofocus autocomplete="name" />
        </div>
        <x-input-error for="name" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="phone" :value="__('Phone')" />
            <x-input wire:model.lazy='phone' type="phone" class="block w-full mt-1" :value="old('phone', $phone)" placeholder="{{__('Branch phone')}}" autocomplete="phone" />
        </div>
        <x-input-error for="phone" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="email" :value="__('Email')" />
            <x-input wire:model.lazy='email' type="email" class="block w-full mt-1" :value="old('email', $email)" placeholder="{{__('Branch email')}}" autocomplete="email" />
        </div>
        <x-input-error for="email" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="contract_number" :value="__('Contract Number')" />
            <x-input wire:model.lazy='contract_number' type="numeric" min="1" class="block w-full mt-1" :value="old('contract_number', $contract_number)" placeholder="{{__('Contract number')}}" autocomplete="contract_number" />
        </div>
        <x-input-error for="contract_number" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="person_contact" :value="__('Person Contact')" />
            <x-input wire:model.lazy='person_contact' type="text" class="block w-full mt-1" :value="old('person_contact', $person_contact)" placeholder="{{__('Person contact')}}" autocomplete="person_contact" />
        </div>
        <x-input-error for="person_contact" class="mt-2" />
    </div>
</div>
