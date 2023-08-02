<div>
    @foreach ($categories as $category)
        <div class="relative block my-2">
            <label for="{{ $category->name }}" class="flex items-center cursor-pointer">
                <x-checkbox wire:change='setSelected({{ $category->id }})' wire:loading.attr="disabled"
                    class="disabled:opacity-60" checked="checked" id="{{ $category->name }}" />
                <span class="ml-2 text-sm text-gray-600">{{ __($category->name) }}</span>
            </label>
        </div>
    @endforeach

    <div class="mt-4 font-bold text-gray-700 border-b border-green-300">
        {{ __('Filter By Price') }}
    </div>

    <div class="items-center py-2">
        <div class="flex grid-cols-2 gird">
            <div class="w-1/2">
                <div class="flex items-center">
                    <span
                        class="py-[0.32rem] leading-[1.5] px-2 rounded-l text-gray-500 bg-green-200 border-l border-y border-solid border-green-400">$</span>
                    <input type="number" wire:model.lazy='price_min' min="1" placeholder="{{ __('Min') }}"
                        class="peer block w-full py-[0.32rem] px-3 mr-2 leading-[1.5] rounded-r border-r border-y border-solid border-green-400 bg-white text-gray-500 placeholder:text-gray-500 bg-transparent outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:text-gray-700" />
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex items-center">
                    <span
                        class="py-[0.32rem] leading-[1.5] px-2 rounded-l text-gray-500 bg-green-200 border-l border-y border-solid border-green-400">$</span>
                    <input type="number" wire:model.lazy='price_max' min="1" placeholder="{{ __('Max') }}"
                        class="peer block w-full py-[0.32rem] px-3 mr-2 leading-[1.5] rounded-r border-r border-y border-solid border-green-400 bg-white text-gray-500 placeholder:text-gray-500 bg-transparent outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:text-gray-700" />
                </div>
            </div>
        </div>
    </div>

    <x-button wire:click="filterPrice" wire:loading.attr='disabled'
        class="flex justify-center w-full mt-2 disabled:opacity-60">
        {{ __('Apply Filter') }}
        <x-icon-spin wire:loading wire:target="filterPrice" class="ml-1" />
    </x-button>
</div>
