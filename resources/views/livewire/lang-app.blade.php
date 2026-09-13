<div x-data="{ open: false }" class="flex items-center">
    @if ($lang == 'en')
        <img src="{{ asset('icons/spain.png') }}" class="w-4 h-4 mr-1.5" />
        <a href="{{ route('app.lang', 'es') }}" class="text-sm font-medium text-indigo-800 hover:text-indigo-600">{{ __('Spanish') }}</a>
    @else
        <img src="{{ asset('icons/united_states.png') }}" class="w-4 h-4 mr-1.5" />
        <a href="{{ route('app.lang', 'en') }}" class="text-sm font-medium text-indigo-800 hover:text-indigo-600">{{ __('English') }}</a>
    @endif
</div>
