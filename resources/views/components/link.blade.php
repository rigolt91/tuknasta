@props(['active'])

@php
    $classes = $active ?? false ? 'inline-flex items-center pt-1 sm:text-sm font-bold leading-5 text-gray-200 hover:text-gray-400 focus:outline-none focus:text-gray-300 transition duration-150 ease-in-out' : 'inline-flex items-center pt-1 text-sm font-medium leading-5 text-gray-200 hover:text-gray-100 focus:outline-none focus:text-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
