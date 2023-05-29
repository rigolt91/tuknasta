<div>
    <div class="pt-8">
        <div class="mt-2 mb-4">
            <div class="relative">
                <x-label for="name" :value="__('Name')" />
                <x-input wire:model.lazy='name' type="text" class="block w-full mt-1" :value="old('name', $name)" placeholder="{{__('Subcategory name')}}" autofocus autocomplete="name" />
            </div>
            <x-input-error for="name" class="mt-2" />
        </div>
        <div class="mt-2 mb-4">
            <div class="relative">
                <x-label for="category" :value="__('Category')" />
                <x-select wire:model='category_id'>
                    <option value="" selected disabled>{{ __('Category name') }}</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>
            <x-input-error for="category_id" class="mt-2" />
        </div>
    </div>
</div>
