@props([
    'width' => '',
    'height' => '',
])

<img src="{{ asset('logo-sm.png') }}" width="{{ $width }}" height="{{ $height }}"
    {{ $attributes->merge(['class' => 'rounded-full']) }} alt="TuKanasta">
