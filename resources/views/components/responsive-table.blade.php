@props(['headers', 'rows'])

{{-- Desktop Table View --}}
<div class="overflow-x-auto hidden md:block">
    <table class="min-w-full bg-white rounded-xl shadow-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 whitespace-nowrap">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($rows as $row)
                <tr class="hover:bg-gray-50">
                    @foreach ($row as $i => $cell)
                        <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap align-middle">
                            {!! $cell !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mobile Card View --}}
<div class="md:hidden space-y-4">
    @foreach ($rows as $row)
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-4">
            @foreach ($headers as $index => $header)
                <div
                    class="flex justify-between items-start py-1 border-b border-dashed border-gray-100 last:border-b-0">
                    <span
                        class="text-xs text-gray-500 font-medium uppercase tracking-wide w-1/2">{{ $header }}</span>
                    @if (strtolower($header) === 'aksi')
                        <div class="w-1/2 flex flex-wrap justify-end gap-2 text-sm">
                            {!! $row[$index] !!}
                        </div>
                    @else
                        <div class="text-sm text-gray-800 w-1/2 text-right">{!! $row[$index] !!}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
