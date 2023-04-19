@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'text-gray-500 w-full border border-green-400 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm']) }}>
    {{ $slot }}
</textarea>
