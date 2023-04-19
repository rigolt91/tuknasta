<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-green-100 border border-green rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:scale-105 duration-150 hover:bg-green-500 hover:shadow-md focus:bg-green-500 hover:border-green-600 active:bg-green-600 active:shadow-md focus:outline-none focus:ring-offset-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
