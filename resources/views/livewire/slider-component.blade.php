<div x-data="{ open: false }" class="mx-4 mb-14 sm:mx-2">
    @if($sliders->count() > 0)
        <div @mouseover="open = true" @mouseout="open = false" class="relative">
            @foreach ($sliders as $slider)
                <div class="relative flex items-center hidden w-full slide sm:rounded">
                    <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" class="rounded-md shadow-md">
                    <div class="absolute px-8 sm:px-28">
                        <div class="lg:text-4xl md:block hidden text-2xl font-bold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.3)] mb-4">
                            {{ __($slider->title) }}
                        </div>
                        <div class="sm:text-xl md:block hidden text-lg text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.3)] mb-4">
                            {{ __(substr($slider->text, 0, 150)) }}
                        </div>
                        @if($slider->text)
                        <a href="{{ url($slider->link) }}" class="w-[150px] text-center items-center md:block hidden px-2 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition duration-150 ease-in-out bg-green-100 border rounded-md border-green hover:scale-105 hover:bg-green-500 hover:shadow-md focus:bg-green-500 hover:border-green-600 active:bg-green-600 active:shadow-md focus:outline-none focus:ring-offset-2 focus:ring-green-500">
                            {{ __('Buy now') }}
                        </a>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- The previous button -->
            <a x-show="open" :class="open == true ? 'transition duration-300 easy-in-out' : ''"
                class="absolute left-4 top-1/2 py-2.5 px-3.5 rounded bg-white/50 hover:bg-white/60 text-white cursor-pointer"
                onclick="moveSlide(-1)">
                <svg class="text-gray-700" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>

            <!-- The next button -->
            <a x-show="open" :class="open == true ? 'transition duration-300 easy-in-out' : ''"
                class="absolute right-4 top-1/2 py-2.5 px-3.5 rounded bg-white/50 hover:bg-white/60 text-white cursor-pointer"
                onclick="moveSlide(1)">
                <svg class="text-gray-700" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>

            <!-- The dots -->
            <div class="relative flex items-center justify-center -mt-4 space-x-1 sm:-mt-8">
                @for ($i = 1; $i <= $sliders->count(); $i++)
                    <div class="w-8 h-1 cursor-pointer dot" onclick="currentSlide({{ $i }})"></div>
                @endfor
            </div>
        </div>

        @section('scripts')
            <script>
                let slideIndex = 1;
                showSlide(slideIndex);

                const moveSlide = (moveStep) => showSlide(slideIndex += moveStep);

                const currentSlide = (n) => showSlide(slideIndex = n);

                function showSlide(n) {
                    let i;

                    const slides = document.getElementsByClassName("slide");
                    const dots = document.getElementsByClassName('dot');

                    if (n > slides.length) slideIndex = 1;
                    if (n < 1) slideIndex = slides.length;

                    for (i = 0; i < slides.length; i++) {
                        slides[i].classList.add('hidden');
                    }

                    for (i = 0; i < dots.length; i++) {
                        dots[i].classList.remove('bg-green-700');
                        dots[i].classList.add('bg-white/20');
                    }

                    slides[slideIndex - 1].classList.remove('hidden');

                    slides[slideIndex - 1].style.opacity = 0;
                    slides[slideIndex - 1].style.display = "hidden";
                    (function fade() {
                        let val = parseFloat(slides[slideIndex - 1].style.opacity);

                        if (!((val += 0.1) > 1)) {
                            slides[slideIndex - 1].style.opacity = val;
                            requestAnimationFrame(fade);
                        }
                    })();

                    dots[slideIndex - 1].classList.remove('bg-white/20');
                    dots[slideIndex - 1].classList.add('bg-green-700');
                }

                setInterval(() => {
                    moveSlide(1);
                }, 8000);
            </script>
        @endsection
    @else
        <div class="slide relative flex items-center w-full sm:h-[350px] h-[450px] bg-no-repeat bg-center bg-cover bg-gray-200 object-cover animate-pulse shadow-md sm:rounded">
            <div class="px-8 sm:px-28">
                <div class="sm:text-4xl text-2xl font-bold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.3)] mb-4"></div>
                <div class="sm:text-2xl text-lg text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.3)] mb-4"></div>
            </div>
        </div>
    @endif
</div>
