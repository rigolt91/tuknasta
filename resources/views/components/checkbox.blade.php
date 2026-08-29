@props(['checked' => ''])

<input type="checkbox" {{ $checked }} {!! $attributes->merge(['class' => 'rounded border border-indigo-500 p-2 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer']) !!}>
