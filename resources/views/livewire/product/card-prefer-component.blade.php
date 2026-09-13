<div>
    <div class="m-2" wire:loading.class="opacity-60">
        <div
            class="flex flex-col h-full overflow-hidden transition duration-200 ease-out bg-white border border-gray-100 rounded-2xl hover:-translate-y-1 hover:shadow-lg">
            <a href="{{ route('product.details', $slug) }}" wire:loading.class="animation-pulse"
                class="relative flex items-center justify-center bg-indigo-50 aspect-[4/3]">
                @if($previous_price)
                    <span class="absolute z-10 px-2 py-0.5 text-[0.65rem] font-bold text-white rounded-full top-2 left-2 bg-accent">
                        -{{ round((1 - $price / $previous_price) * 100) }}%
                    </span>
                @endif
                <img src="{{ Storage::url($product->image) }}" class="object-cover w-full h-full" alt="{{ $product->name }}">
            </a>

            <div class="relative flex flex-col flex-1 gap-1 px-3 py-3">
                @if($branch)
                    <span class="text-[0.65rem] font-bold tracking-wide uppercase text-indigo-700">{{ $branch }}</span>
                @endif

                <div class="text-sm font-bold leading-snug text-gray-900 font-display">
                    {{ $name }}
                </div>

                <div class="flex items-center gap-1">
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $starts >= $i ? '#dd7f31' : '#e5e7eb' }}">
                                <path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.9-6.2-3.3-6.2 3.3 1.2-6.9-5-4.9 6.9-1L12 2Z"/>
                            </svg>
                        @endfor
                    </div>
                    @if($reviews > 0)
                        <span class="text-[0.65rem] text-gray-400">({{ $reviews }})</span>
                    @endif
                </div>

                <div class="flex items-end justify-between mt-auto pt-1">
                    <div class="font-display">
                        <span class="text-base font-bold text-gray-900">${{ number_format($price, 2) }}</span>
                        @if($previous_price)
                            <span class="ml-1 text-xs font-medium text-gray-400 line-through">${{ number_format($previous_price, 2) }}</span>
                        @endif
                    </div>

                    <button type="button" wire:click='addProductCart({{ $product }})' wire:loading.attr='disabled'
                        aria-label="{{ __('Add to cart') }}"
                        class="flex items-center justify-center w-8 h-8 text-indigo-700 transition rounded-full bg-indigo-50 hover:bg-indigo-700 hover:text-white disabled:opacity-60">
                        <svg height="16" width="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
