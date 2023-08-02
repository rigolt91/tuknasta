@props([
    'width' => '40',
    'height' => '40',
    'show' => '',
])

<img src="{{ asset('logo.png') }}" width="{{ $width }}" height="{{ $height }}"
    {{ $attributes->merge(['class' => 'rounded-full']) }} alt="TuKanasta">
