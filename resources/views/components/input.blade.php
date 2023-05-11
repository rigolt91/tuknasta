@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'peer block min-h-[48px] w-full rounded border border-solid border-green-400 bg-white text-gray-500 placeholder:text-gray-500 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:ring-green-500 focus:border-green-500 focus:text-gray-700']) !!}>
