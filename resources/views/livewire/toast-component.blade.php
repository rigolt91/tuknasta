<div class="fixed sm:top-40 top-40 right-4">
    @if ($product)
        <div id="toast" x-data="{ open: true }" x-show="open" x-transition.duration.500ms
            class="overflow-hidden border border-green-200 bg-white shadow rounded w-[300px] mb-2 hover:scale-110 transition duration-500 ease-in-out animate-pulse hover:animate-none cursor-pointer">
            <button @click="open = ! open" class="float-right my-4 mx-2 hover:bg-gray-100 p-2 rounded">
                <svg width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path
                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                </svg>
            </button>

            <div class="flex" wire:click="details('{{ $product->slug }}')">
                <img src="{{ Storage::url($product->image) }}"
                    class="object-cover object-center w-16 h-16 mr-4 border-r-1 border-green-500">

                <div class="my-2">
                    <h1 class="font-bold text-sm text-green-800">{{ __('Oferta Especial !!') }}</h1>
                    <h1 class="text-sm">{{ $product->name }}</h1>
                </div>
            </div>
        </div>

        @section('scripts')
            <script>
                let toast = document.getElementById('toast');

                toast.classList.add('hidden');

                setInterval(() => {
                    toast.style.opacity = 0;
                    toast.classList.remove('hidden');

                    (function fade() {
                        let val = parseFloat(toast.style.opacity);

                        if (!((val += 0.1) > 1)) {
                            toast.style.opacity = val;
                            requestAnimationFrame(fade);
                        }
                    })();
                }, 3000);
            </script>
        @endsection
    @endif
</div>
