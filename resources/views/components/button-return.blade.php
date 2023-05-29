@props(['route' => $route])

<a href="{{ $route }}" class="inline-flex items-center w-full px-2 py-2 mt-4 text-xs font-semibold tracking-widest text-gray-800 uppercase transition duration-150 ease-in-out bg-green-100 border border-green sm:rounded hover:bg-green-500 hover:scale-105 hover:shadow-md focus:bg-green-500 active:bg-green-600 active:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
    <svg fill="currentColor" class="h-5 mr-2 bi bi-arrow-left-square" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
    </svg>
    {{ $slot }}
</a>
