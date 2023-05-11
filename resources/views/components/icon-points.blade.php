@props([
    'width'  => '16',
    'height' => '16',
    'color'  => 'currentColor'
])

<svg {{ $attributes->merge(['class' => '']) }} width="{{ $width }}" height="{{ $height }}" fill="{{ $color }}" viewBox="0 0 16 16">
    <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
