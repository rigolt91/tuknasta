<div class="pt-8">
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="name" :value="__('Name')" />
            <x-input wire:model.lazy='name' type="text" class="mt-1 block w-full" :value="old('name', $name)" placeholder="{{__('Category name')}}" autofocus autocomplete="name" />
        </div>
        <x-input-error for="name" class="mt-2" />
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="description" :value="__('Description')" />
            <x-input wire:model.lazy='description' type="text" class="mt-1 block w-full" :value="old('description', $description)" placeholder="{{__('Category description')}}" autocomplete="description" />
        </div>
        <x-input-error for="description" class="mt-2" />
    </div>
    <div class="flex justify-end -mb-4">
        <x-button-danger wire:click="$emit('closeModal')" wire:loading.attr='disabled' type="button" class="float-end">
            {{ __('Cancel') }}
        </x-button-danger>
        <x-button type="submit" class="ml-2">
            {{ __('Accept') }}
        </x-button>
    </div>
</div>
