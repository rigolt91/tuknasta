<div>
    @if($lang == 'en')
        <a href="{{ route('app.lang', 'es') }}" ><img src="{{ asset('icons/spain.png') }}" class="sm:w-8 w-20" alt="ES"></a>
    @else
        <a href="{{ route('app.lang', 'en') }}" ><img src="{{ asset('icons/united_states.png') }}" class="sm:w-8 w-20" alt="EN"></a>
    @endif
</div>
