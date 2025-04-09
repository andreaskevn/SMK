@props([
    'perPageOptions' => [5, 10, 25, 50],
    'value' => request('perPage')
])

<div class="flex items-center space-x-2">
    <label for="perPage" class="text-sm text-gray-700">Tampilkan:</label>
    <select name="perPage" id="perPage" onchange="this.form.submit()"
        class="border rounded px-2 py-1 text-sm">
        @foreach ($perPageOptions as $option)
            <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
</div>
