<div>
    <div x-data="{openNotify: false, open: false}" class="flex flex-col justify-center items-center">
        <div x-cloak x-show="openNotify" x-transition:enter="transition ease-in-out duration-200"
            x-init="setTimeout(() => {
                open = true;
                openNotify = true;
            }, 5000)"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="absolute top-32 right-2 flex flex-col space-y-0 rounded-md shadow-md display"
        >
            <div
                x-cloak x-show="open"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="bg-white cursor-pointer rounded-lg w-80 space-y-2"
            >
                <!-- Content -->
                <div class="flex h-full">
                    <a href="{{ route('product.details', $product->slug) }}" class="bg-white rounded sm:w-4/12"  wire:loading.class="animation-pulse">
                        <img src="{{ Storage::url($product->image) }}" class="w-full h-24 sm:h-full sm:rounded-l text-sm text-center" alt="{{ $product->name }}">
                    </a>
                    <div class="mx-2 my-1 w-8/12">
                        <div class="text-sm sm:text-md text-gray-800 font-bold border-b py-1 ">
                            {{ $product->name }}
                            <div>
                                <div @click="open = !open" class="float-right -mt-6 h-6 w-6 flex justify-center items-center bg-gray-200 rounded-full cursor-pointer hover:bg-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="text-sm text-gray-700 py-1">{{ substr($product->short_description, 0, 50) }}...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
