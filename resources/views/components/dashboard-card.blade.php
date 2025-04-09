@props(['title', 'value', 'icon' => ''])

<div class="bg-white shadow-md rounded-2xl p-4 flex items-center space-x-4">
    @if ($icon)
        <div class="text-blue-500 text-3xl">
            {!! $icon !!}
        </div>
    @endif
    <div>
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <h2 class="text-xl font-bold text-gray-800">{{ $value }}</h2>
    </div>
</div>
