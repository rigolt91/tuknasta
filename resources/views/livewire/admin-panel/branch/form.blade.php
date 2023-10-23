<div class="pt-8">
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="name" :value="__('Name')" />
            <x-input wire:model.lazy='name' type="text" class="block w-full mt-1" :value="old('name', $name)" placeholder="{{__('Suppliers name')}}" autofocus autocomplete="name" />
        </div>
        <x-input-error for="name" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="phone" :value="__('Phone')" />
            <x-input wire:model.lazy='phone' type="phone" class="block w-full mt-1" :value="old('phone', $phone)" placeholder="{{__('Suppliers phone')}}" autocomplete="phone" />
        </div>
        <x-input-error for="phone" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="email" :value="__('Email')" />
            <x-input wire:model.lazy='email' type="email" class="block w-full mt-1" :value="old('email', $email)" placeholder="{{__('Suppliers email')}}" autocomplete="email" />
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
    <div class="mt-2 mb-4">
        <div class="relative border border-green-400 rounded-md">
            <x-label for="check_sub_supplier" :value="__('Sub Supplier')" />
            <label class="relative inline-flex items-center mt-4 ml-3 cursor-pointer">
                <input type="checkbox" wire:click="setCheckSubSupplier" class="sr-only peer" @if($sub_branch) checked @endif>
                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
            </label>
        </div>
        <x-input-error for="mode" class="mt-2" />
    </div>
    @if($check_sub_supplier)
        <div class="my-2 mb-4">
            <div class="relative">
                <x-label for="sub_branch" :value="__('Supplier')" />
                <x-select wire:model='sub_branch' class="mt-1.5" required>
                    <option value="" selected>{{__('Suppliers')}}</option>
                    @foreach ($branches as $branch)
                        <option value={{ $branch->id }}>{{ $branch->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="sub_branch" class="mt-2" />
        </div>
    @endif
</div>
