@props([
    'disabled' => false,
])

<select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'peer block min-h-[48px] w-full rounded border border-solid border-indigo-400 bg-white text-gray-500 focus:text-gray-700 blur:text-gray-700 bg-transparent py-[0.60rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-indigo-500 focus:border-indigo-500 focus:placeholder:opacity-100']) }}>
    {{ $slot }}
</select>
