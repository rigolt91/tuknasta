@props(['value'])

<label {{ $attributes->merge(['class' => 'pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-gray-600 transition-all duration-200 ease-out -translate-y-[0.9rem] scale-[0.8] peer-focus:text-green-800 bg-white px-1']) }}>
    {{ $value ?? $slot }}
</label>
