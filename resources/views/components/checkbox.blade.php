@props(['checked' => ''])

<input type="checkbox" {{ $checked }} {!! $attributes->merge(['class' => 'rounded border border-green-500 p-2 text-green-600 shadow-sm focus:ring-green-500 cursor-pointer']) !!}>
