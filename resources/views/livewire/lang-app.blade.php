<div x-data="{ open: false }" class="flex">
    @if ($lang == 'en')
        <img src="{{ asset('icons/spain.png') }}" class="mr-1" />
        <a href="{{ route('app.lang', 'es') }}" class="text-white text-sm">{{ __('Spanish') }}</a>
    @else
        <img src="{{ asset('icons/united_states.png') }}" class="mr-1" />
        <a href="{{ route('app.lang', 'en') }}" class="text-white text-sm">{{ __('English') }}</a>
    @endif
</div>
