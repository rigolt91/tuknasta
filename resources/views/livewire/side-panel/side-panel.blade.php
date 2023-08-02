<div class=" {{ $hidden }}">
    <section x-data="{ open: @entangle('open') }" @keydown.window.escape="open = false" x-show="open" x-cloak class="relative z-10"
        aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
        <div x-show="open" x-cloak x-transition:enter="ease-in-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-300 bg-opacity-30 transition-opacity" @click="open = false"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full">
                    <div x-show="open" x-cloak
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="-translate-x-full" x-transition:enter-end="-translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="-translate-x-0" x-transition:leave-end="-translate-x-full"
                        class="pointer-events-auto w-screen max-w-md" @click.away="open = true">
                        <div class="flex h-full w-4/5 flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                            <header class="px-4 sm:px-6">
                                <div class="flex items-start justify-between border-b-2 border-green-300">
                                    <h2 class="text-lg font-medium text-gray-900 pb-2" id="slide-over-title">
                                        {{ __($this->title) }}
                                    </h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button wire:click='closePanel' type="button"
                                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 hover:bg-gray-100 hover:p-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                            @click="open = false">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </header>
                            <article class="relative mt-4 flex-1 px-4 sm:px-6">
                                @if ($component)
                                    @livewire($component)
                                @else
                                    <div class="absolute inset-0 px-4 sm:px-6">
                                        <div class="h-full border-2 border-dashed border-gray-200" aria-hidden="true">
                                        </div>
                                    </div>
                                @endif
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
