@props(['route' => ''])

<a {{ $route ? "href=$route" : '' }} type="button" {{ $attributes->merge(['class' => 'items-center w-full inline-flex px-4 py-2 bg-green-800 border border-transparent sm:rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 hover:scale-105 duration-150 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-[0_4px_9px_-4px_#14a44d] hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)]']) }}>
    <svg fill="currentColor" class="h-5 mr-2 bi bi-credit-card-2-back-fill" viewBox="0 0 16 16">
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5H0V4zm11.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zM0 11v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1H0z"/>
    </svg>
    {{ $slot }}
</a>
