<div>
    <div x-data="{ open: true }" class="flex items-center justify-center w-full h-200">
        <div @mouseover="open = true"
            class="w-full h-[270px] relative flex items-center justify-center">
            <button x-show="open"
                :class="open == true ? 'block transition duration-300 easy-in-out' : 'sm:hidden'"
                class="block absolute z-30 left-0 ml-5 py-2.5 px-3.5 rounded-md bg-white/20 hover:bg-white/50 text-white cursor-pointer"
                id="btnPrev"
            >
                <svg class="text-white" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden">
                <div id="sliderCategories"
                    class="flex items-center justify-start h-full mx-4 transition duration-700 ease-out gap-x-8">
                    @if($categories->count() > 0)
                        @foreach ($categories as $category)
                            <div id="divCategory" wire:click="getProducts({{ $category->id }})" class="relative w-full transition duration-700 ease-in-out cursor-pointer shrink-0 sm:w-auto hover:scale-110">
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                    class="flex items-center justify-center object-cover object-center w-auto h-[200px] text-xs bg-gray-200 rounded-md shadow-md sm:w-64 sm:h-36" />
                                <div
                                    class="absolute flex items-center justify-center w-full pt-2 text-sm font-bold text-center text-gray-800 uppercase sm:w-64">
                                    {{ $category->name }}
                                </div>
                            </div>
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
                class="block absolute z-30 right-0 mr-5 py-2.5 px-3.5 rounded-md bg-white/20 hover:bg-white/50 text-white cursor-pointer"
                id="btnNext"
            >
                <svg class="text-white" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        let next = document.getElementById('btnNext');
        let prev = document.getElementById('btnPrev');
        let screenWidth = screen.width;
        let defaultTransform = 0;
        var sliderCategories = document.getElementById('sliderCategories');
        let trnslateWidth = screenWidth > 600 ? 290 : screenWidth-32; 
        console.log(screenWidth);

        function goNext() {
            defaultTransform = defaultTransform - parseInt(trnslateWidth);
            if (Math.abs(defaultTransform) >= sliderCategories.scrollWidth / 1.7) defaultTransform = 0;
            sliderCategories.style.transform = "translateX(" + defaultTransform + "px)";
        }
        next.addEventListener("click", goNext);

        function goPrev() {
            if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
            else defaultTransform = defaultTransform + parseInt(trnslateWidth);
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
