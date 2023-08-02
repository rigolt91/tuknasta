<div class="pt-8">
    <div class="flex my-2">
        <div class="flex items-center justify-center w-40 mr-4 text-sm text-gray-500 border border-green-400 rounded-md"
            style="height: 112px; width:140px;">
            @if ($image)
                @isset($category)
                    <img wire:loading.class='opacity-25' wire:target='image'
                        src="{{ $image !== $category->image ? $image->temporaryUrl() : Storage::url($category->image) }}"
                        class="rounded-md flex items-center justify-center text-xs w-full h-full" alt="{{ $category->name }}">
                @else
                    <img wire:loading.class='opacity-25' wire:target='image' src="{{ $image->temporaryUrl() }}"
                        class="rounded-md flex items-center justify-center text-xs w-full h-full">
                @endisset
            @else
                <span wire:loading.class='hidden'>"JPEG"</span>
            @endif
            <div wire:loading wire:target='image' class="absolute text-bold">{{ __('Charging') }}...</div>
        </div>

        <div class="w-full">
            <div class="mb-4">
                <div class="relative">
                    <x-label for="image" :value="__('Image')" />
                    <x-input wire:model='image' type="file"
                        class="text-sm file:p-2 file:border-none file:bg-green-200 file:text-gray-500 file:cursor-pointer focus:outline-none focus:shadow-[0_0_0_1px] focus:shadow-green-500 hover:file:bg-green-700 hover:file:text-white block w-full"
                        :value="old('image', $image)" autofocus autocomplete="image" />
                </div>
                <x-input-error for="image" class="mt-2" />
            </div>
            <div class="mt-2 mb-4">
                <div class="relative">
                    <x-label for="name" :value="__('Name')" />
                    <x-input wire:model.lazy='name' type="text" class="mt-1 block w-full" :value="old('name', $name)"
                        placeholder="{{ __('Category name') }}" autofocus autocomplete="name" />
                </div>
                <x-input-error for="name" class="mt-2" />
            </div>
        </div>
    </div>
    <div class="mt-2 mb-4">
        <div class="relative">
            <x-label for="description" :value="__('Description')" />
            <x-input wire:model.lazy='description' type="text" class="mt-1 block w-full" :value="old('description', $description)"
                placeholder="{{ __('Category description') }}" autocomplete="description" />
        </div>
        <x-input-error for="description" class="mt-2" />
    </div>
</div>
