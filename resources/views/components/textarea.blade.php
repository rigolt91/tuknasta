@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'text-gray-500 w-full border border-indigo-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    {{ $slot }}
</textarea>
