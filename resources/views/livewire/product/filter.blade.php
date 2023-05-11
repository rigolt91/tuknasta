<div>
    <div class="pb-1 text-gray-700 -mt-2 mb-2 border-b border-green-300 font-bold">
        {{ __('Categories') }}
    </div>

    @foreach ($categories as $category)
        <div class="block my-2 relative">
            <label for="{{ $category->name }}" class="flex items-center  cursor-pointer">
                <x-checkbox wire:change='setCategorySelected({{ $category->id }})' checked="checked"  id="{{ $category->name }}" />
                <span class="ml-2 text-sm text-gray-600">{{ $category->name }}</span>
            </label>
        </div>
    @endforeach

    <div class="text-gray-700 font-bold border-b border-green-300 mt-4">
        {{ __('Filter by price') }}
    </div>

    <div class="items-center py-2">
        <div class="gird grid-cols-2 flex">
            <div class="w-1/2">
                <div class="flex items-center">
                    <span class="py-[0.32rem] leading-[1.5] px-2 rounded-l text-gray-500 bg-green-200 border-l border-y border-solid border-green-400">$</span>
                    <input type="number" wire:model='price_min' min="1" placeholder="{{__('Minimum')}}" class="peer block w-full py-[0.32rem] px-3 mr-2 leading-[1.5] rounded-r border-r border-y border-solid border-green-400 bg-white text-gray-500 placeholder:text-gray-500 bg-transparent outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:text-gray-700" />
                </div>
            </div>
            <div class="w-1/2">
                <div class="flex items-center">
                    <span class="py-[0.32rem] leading-[1.5] px-2 rounded-l text-gray-500 bg-green-200 border-l border-y border-solid border-green-400">$</span>
                    <input type="number" wire:model='price_max' min="1" placeholder="{{__('Maximum')}}" class="peer block w-full py-[0.32rem] px-3 mr-2 leading-[1.5] rounded-r border-r border-y border-solid border-green-400 bg-white text-gray-500 placeholder:text-gray-500 bg-transparent outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:text-gray-700" />
                </div>
            </div>
        </div>
    </div>

    <x-button wire:click="filterPrice" wire:loading.attr='disabled' class="mt-2 w-full disabled:opacity-60 flex justify-center">
        {{ __('Apply Filter') }}
    </x-button>
</div>
