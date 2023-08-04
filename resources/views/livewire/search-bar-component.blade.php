<div class="w-full">
    <form action="{{ route('products') }}" class="flex w-full" method="get">
        <div class="relative flex justify-center">
            <div x-data="{
                textButton: '{{ __('All Categories') }}',
                open: false,
                toggle() {
                    if (this.open) {
                        return this.close()
                    }

                    this.$refs.button.focus()

                    this.open = true
                },
                close(focusAfter) {
                    if (!this.open) return

                    this.open = false

                    focusAfter && focusAfter.focus()
                }
            }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']"
                class="relative">
                <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                    :aria-controls="$id('dropdown-button')" type="button"
                    class="flex items-center justify-center w-64 px-2 py-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-700 border border-green-700 border-r-none rounded-l-md hover:scale-105 hover:bg-green-500 hover:shadow-md focus:bg-green-500 hover:border-green-600 active:bg-green-600 active:shadow-md focus:outline-none focus:ring-offset-2 focus:ring-green-500">

                    <span x-text="textButton">{{ __('All Categories') }}</span>

                    <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" class="w-5 h-5 text-white"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-ref="panel" x-show="open" x-transition.origin.top.left x-on:click.outside="close($refs.button)"
                    :id="$id('dropdown-button')" style="display: none;"
                    class="absolute left-0 z-50 w-64 mt-0 bg-white border rounded-md shadow-lg">
                    @foreach ($categories as $category)
                        <a href="#"
                            @click="$wire.setCategory({{ $category->id }}), textButton = '{{ $category->name }}', open = false"
                            class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-1.5 text-left text-sm hover:bg-gray-100 disabled:text-gray-500">
                            <span class="text-gray-600">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <input name="category_id" type="hidden" wire:model="category_id">
        <input name="search" type="search"
            class="w-full px-6 border-green-700 focus:border-white focus:ring-green-500"
            placeholder="{{ __('Search products') }}..." />

        <x-button-inline type="submit" class="px-3 bg-green-700 border border-green-700 rounded-l-none">
            <svg height="18" width="18" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </x-button-inline>
    </form>
</div>
