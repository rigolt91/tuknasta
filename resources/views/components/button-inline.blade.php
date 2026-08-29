<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2 bg-indigo-100 border border-green rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:scale-105 duration-150 hover:bg-indigo-500 hover:shadow-md focus:bg-indigo-500 hover:border-indigo-600 active:bg-indigo-600 active:shadow-md focus:outline-none focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
