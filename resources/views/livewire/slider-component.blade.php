<div x-data="{ open: false }">
    @if($sliders->count() > 0)
        <div @mouseover="open = true" @mouseout="open = false" class="relative">
            @foreach ($sliders as $slider)
                <div class="hidden w-full slide px-4 sm:px-2">
                    <div class="grid items-center gap-8 sm:grid-cols-2">
                        <div>
                            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-indigo-700 before:block before:h-0.5 before:w-4 before:bg-current">
                                {{ __('Featured') }}
                            </span>
                            <div class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl font-display mb-4">
                                {{ __($slider->title) }}
                            </div>
                            <div class="max-w-md mb-6 text-sm text-gray-600 sm:text-base">
                                {{ __(substr($slider->text, 0, 150)) }}
                            </div>
                            @if($slider->text)
                            <a href="{{ url($slider->link) }}" class="inline-flex items-center gap-2 px-5 py-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out rounded-full shadow-lg bg-indigo-700 hover:bg-indigo-600 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Buy now') }}
                            </a>
                            @endif

                            <div class="flex flex-wrap gap-5 mt-8 text-xs text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-700"><path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3Z"/><path d="m9 12 2 2 4-4"/></svg>
                                    {{ __('Verified payment') }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-700"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7z"/><circle cx="7" cy="19" r="1.6"/><circle cx="17.5" cy="19" r="1.6"/></svg>
                                    {{ __('Delivery by municipality') }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-700"><path d="M3 21V7l9-4 9 4v14"/><path d="M9 21v-6h6v6"/></svg>
                                    {{ __('Multiple vendors') }}
                                </span>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="flex items-center justify-center overflow-hidden border shadow-xl bg-gradient-to-br from-indigo-50 to-white border-gray-100/50 rounded-2xl">
                                <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}"
                                    class="object-cover w-full h-56 sm:h-64 lg:h-96 rounded-xl" />
                            </div>

                            <!-- The previous button -->
                            <a x-show="open" :class="open == true ? 'transition duration-300 easy-in-out' : ''"
                                class="absolute z-10 flex items-center justify-center w-9 h-9 text-gray-700 rounded-full shadow left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white cursor-pointer"
                                onclick="moveSlide(-1)">
                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none">
                                    <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- The next button -->
                            <a x-show="open" :class="open == true ? 'transition duration-300 easy-in-out' : ''"
                                class="absolute z-10 flex items-center justify-center w-9 h-9 text-gray-700 rounded-full shadow right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white cursor-pointer"
                                onclick="moveSlide(1)">
                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none">
                                    <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- The dots -->
            <div class="relative flex items-center justify-center gap-1.5 mt-4 hidden">
                @for ($i = 1; $i <= $sliders->count(); $i++)
                    <div class="w-6 h-1.5 rounded-full cursor-pointer dot bg-gray-200" onclick="currentSlide({{ $i }})"></div>
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
                        dots[i].classList.remove('bg-indigo-700');
                        dots[i].classList.add('bg-gray-200');
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

                    dots[slideIndex - 1].classList.remove('bg-gray-200');
                    dots[slideIndex - 1].classList.add('bg-indigo-700');
                }

                setInterval(() => {
                    moveSlide(1);
                }, 8000);
            </script>
        @endsection
    @else
        <div class="grid items-center w-full gap-8 sm:grid-cols-2">
            <div>
                <div class="w-24 h-3 mb-4 bg-gray-100 rounded animate-pulse"></div>
                <div class="w-3/4 h-8 mb-3 bg-gray-100 rounded animate-pulse"></div>
                <div class="w-full h-4 mb-6 bg-gray-100 rounded animate-pulse"></div>
                <div class="w-32 h-10 bg-gray-100 rounded-full animate-pulse"></div>
            </div>
            <div class="p-6 border bg-gray-50 border-gray-100 rounded-2xl sm:p-8">
                <div class="bg-gray-100 h-56 sm:h-64 lg:h-72 rounded-xl animate-pulse"></div>
            </div>
        </div>
    @endif
</div>
