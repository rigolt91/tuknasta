<div>
    <div x-data="{ open: false }" class="flex items-center justify-center w-full h-200 px-2">
        <div @mouseover="open = true" @mouseout="open = false"
            class="w-full h-[270px] relative flex items-center justify-center">
            <button x-show="open" aria-label="slide backward"
                :class="open == true ? 'block transition duration-300 easy-in-out' : 'sm:hidden'"
                x-transition.duration.300ms
                class="block absolute z-30 left-0 ml-5 py-2.5 px-3.5 rounded-md bg-transparent bg-white/20 hover:bg-white/50 text-white cursor-pointer"
                id="prev">
                <svg class="text-gray-100" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden">
                <div id="slider"
                    class="h-full flex mx-4 gap-x-8 items-center justify-start transition ease-out duration-700">
                    @foreach ($categories as $category)
                        <div wire:click="getProducts({{ $category->id }})"
                            class="shrink-0 relative w-full sm:w-auto transition ease-in-out duration-700 hover:scale-110 cursor-pointer">
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="object-cover object-center w-auto h-auto sm:w-64 sm:h-36 rounded-md shadow-md bg-gray-500 text-xs flex items-center justify-center" />
                            <div
                                class="absolute flex items-center w-full sm:w-64 pt-2 justify-center text-center text-sm font-bold uppercase text-gray-800">
                                {{ $category->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button x-show="open" aria-label="slide forward"
                :class="open == true ? 'block transition duration-300 easy-in-out' : 'sm:hidden'"
                class="block absolute z-30 right-0 mr-5 py-2.5 px-3.5 rounded-md bg-transparent bg-white/20 hover:bg-white/50 text-white cursor-pointer"
                id="next">
                <svg class="text-gray-100" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let defaultTransform = 0;
        let slider = document.getElementById('slider');

        function goNext() {
            defaultTransform = defaultTransform - 400;
            var slider = document.getElementById("slider");
            if (Math.abs(defaultTransform) >= slider.scrollWidth / 1.7) defaultTransform = 0;
            slider.style.transform = "translateX(" + defaultTransform + "px)";
        }
        next.addEventListener("click", goNext);

        function goPrev() {
            var slider = document.getElementById("slider");
            if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
            else defaultTransform = defaultTransform + 400;
            slider.style.transform = "translateX(" + defaultTransform + "px)";
        }
        prev.addEventListener("click", goPrev);

        slider.addEventListener('mousedown', (e) => {
            let screenX = screen.width;
            let x = e.clientX;
            x > (screenX / 2) ? goNext() : goPrev();
        });
    </script>
</div>
