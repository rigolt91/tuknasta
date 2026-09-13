<div>
    <div x-data="{ open: true }" class="flex items-center justify-center w-full h-200">
        <div @mouseover="open = true"
            class="w-full h-[168px] relative flex items-center justify-center">
            <button x-show="open"
                :class="open == true ? 'block transition duration-300 easy-in-out' : 'sm:hidden'"
                class="block absolute z-30 left-0 rounded-md bg-white/50 hover:bg-white/60 text-white cursor-pointer"
                id="btnPrev"
            >
                <svg class="text-gray-700" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden">
                <div id="sliderCategories"
                    class="flex items-center justify-start h-full mx-4 transition duration-700 ease-out gap-x-8">
                    @if($categories->count() > 0)
                        @foreach ($categories as $category)
                            <button type="button" wire:click="getProducts({{ $category->id }})"
                                class="group flex w-[180px] shrink-0 flex-col gap-3 rounded-2xl border border-gray-100 bg-white p-4 text-left transition duration-200 ease-out hover:-translate-y-1 hover:border-indigo-100 hover:shadow-lg sm:w-[200px]">
                                <div class="flex items-center justify-center w-12 h-12 overflow-hidden rounded-xl bg-indigo-50">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="object-contain w-8 h-8" />
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 font-display">
                                        {{ $category->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $category->subcategory_count }} {{ __(Str::plural('subcategory', $category->subcategory_count)) }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    @else
                        @for($i=0;$i<5;$i++)
                            <div class="relative w-full transition duration-700 ease-in-out cursor-pointer shrink-0 sm:w-auto hover:scale-110 animate-pulse">
                                <div id="divCategory" class="flex items-center w-auto sm:w-[260px] h-[200px] justify-center object-cover object-center  text-xs bg-gray-200 rounded-md shadow-md sm:w-64 sm:h-36" /></div>
                                <div class="absolute flex items-center justify-center w-full pt-2 text-sm font-bold text-center text-gray-800 uppercase sm:w-64">
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
            <button x-show="open"
                :class="open == true ? 'block transition duration-300 easy-in-out' : 'sm:hidden'"
                class="block absolute z-30 right-0 rounded-md bg-white/50 hover:bg-white/60 text-white cursor-pointer"
                id="btnNext"
            >
                <svg class="text-gray-700" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        let next = document.getElementById('btnNext');
        let prev = document.getElementById('btnPrev');
        let image = window.screen.width;
        let defaultTransform = 0;
        let translateWidth = parseInt(image) > 600 ? 370 : parseInt(image)-32 ;

        function goNext() {
            defaultTransform = defaultTransform - translateWidth;
            if (Math.abs(defaultTransform) >= sliderCategories.scrollWidth / 1) defaultTransform = 0;
            sliderCategories.style.transform = "translateX(" + defaultTransform + "px)";
        }
        next.addEventListener("click", goNext);

        function goPrev() {
            if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
            else defaultTransform = defaultTransform + translateWidth;
            sliderCategories.style.transform = "translateX(" + defaultTransform + "px)";
        }
        prev.addEventListener("click", goPrev);

        sliderCategories.addEventListener('mousedown', (e) => {
            let screenX = screen.width;
            let x = e.clientX;
            x > (screenX / 2) ? goNext() : goPrev();
        });
    </script>
</div>
