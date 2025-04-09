@props(['status'])

@php
    $color = $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
    $label = ucfirst($status);
@endphp

<span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
    {{ $label }}
</span>
