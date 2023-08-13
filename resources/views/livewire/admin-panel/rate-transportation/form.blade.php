<div class="pt-6">
    <div class="sm:mr-2">
        <div class="mt-2 mb-4">
            <div class="relative">
                <x-label for="province_id" :value="__('Province')" />
                <x-select wire:model='province_id' class="mt-1">
                    <option value="" selected>{{__('Provinces')}}</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="province_id" class="mt-2" />
        </div>

        <div class="mt-2 mb-4">
            <div class="relative">
                <x-label for="municipality_id" :value="__('Municipality')" />
                <x-select wire:model='municipality_id' class="mt-1">
                    <option value="" selected>{{__('Municipalities')}}</option>
                    @foreach ($municipalities as $municipality)
                        <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="municipality_id" class="mt-2" />
        </div>

        <div class="my-2 mb-4">
            <div class="relative">
                <x-label for="amount" :value="__('Price')" />
                <x-input wire:model.lazy='amount' type="number" step="any" min="0" class="block w-full mt-1" :value="old('amount', $amount)" placeholder="{{__('Price')}}" autocomplete="amount" />
            </div>
            <x-input-error for="amount" class="mt-2" />
        </div>
    </div>
</div>
