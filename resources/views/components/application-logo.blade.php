@props([
    'width' => '40',
    'height' => '40',
    'show' => '',
])

<svg viewBox="0 0 200 56" xmlns="http://www.w3.org/2000/svg" width="{{ $width }}" height="{{ $height }}"
    {{ $attributes->merge(['class' => 'rounded-full']) }} role="img" aria-label="MarketPlaza">
    <rect x="0" y="4" width="48" height="48" rx="12" fill="#4338ca" />
    <path d="M14 18h4l2.5 14a2.4 2.4 0 0 0 2.4 2h14a2.4 2.4 0 0 0 2.4-1.9l2.4-10.6H19" fill="none" stroke="#ffffff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" />
    <circle cx="24" cy="38" r="1.9" fill="#ffffff" />
    <circle cx="32" cy="38" r="1.9" fill="#ffffff" />
    <text x="58" y="36" font-family="'Nunito', 'Segoe UI', sans-serif" font-size="24" font-weight="800" fill="#0f172a">Market<tspan fill="#4338ca">Plaza</tspan></text>
</svg>
