@props(['placeholder' => 'Cari...'])

<input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}"
    class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
