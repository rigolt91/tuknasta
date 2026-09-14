<div x-data="{ open: false }" class="flex items-center">
    @if ($lang == 'en')
        <img src="{{ asset('icons/spain.png') }}" alt="" class="w-4 h-4 mr-1.5" />
        <a href="{{ route('app.lang', 'es') }}" class="text-sm font-medium text-indigo-800 rounded hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">{{ __('Spanish') }}</a>
    @else
        <img src="{{ asset('icons/united_states.png') }}" alt="" class="w-4 h-4 mr-1.5" />
        <a href="{{ route('app.lang', 'en') }}" class="text-sm font-medium text-indigo-800 rounded hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">{{ __('English') }}</a>
    @endif
</div>
