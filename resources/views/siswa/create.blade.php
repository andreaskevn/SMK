@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('siswa.store') }}" class="space-y-4">
        @csrf

        {{-- Input Nama --}}
        <div>
            <label for="users_name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="users_name" id="users_name" value="{{ old('users_name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            @error('users_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Email --}}
        <div>
            <label for="users_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="users_email" id="users_email" value="{{ old('users_email') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            @error('users_email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Dropdown Pilih Kelas --}}
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <label for="kelas_select" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                <select id="kelas_select" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kelas)
                        @php
                            $sisaGuru = 5 - $kelas->total_guru;
                            $sisaTotal = 30 - ($kelas->total_guru + $kelas->total_murid);
                        @endphp
                        @if ($sisaGuru > 0 && $sisaTotal > 0)
                            <option value="{{ $kelas->id }}" data-name="{{ $kelas->kelas_name }}"
                                data-sisa-total="{{ $sisaTotal }}">
                                {{ $kelas->kelas_name }} | Sisa Total: {{ $sisaTotal }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6">
                <button type="button" onclick="tambahKelas()"
                    class="px-4 py-2 bg-blue-500 text-white rounded">Tambah</button>
            </div>
        </div>

        {{-- Tabel Kelas yang Dipilih --}}
        <div>
            <table class="w-full mt-4 border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Kelas</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel_kelas"></tbody>
            </table>
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
        </div>
    </form>

    <script>
        function tambahKelas() {
            const select = document.getElementById('kelas_select');
            const selectedId = select.value;
            const selectedName = select.options[select.selectedIndex].dataset.name;

            if (!selectedId) return;


            // Cegah duplikasi
            if (document.getElementById('kelas-row-' + selectedId)) {
                alert('Kelas sudah dipilih!');
                return;
            };

            const tabel = document.getElementById('tabel_kelas');
            const row = document.createElement('tr');
            row.id = 'kelas-row-' + selectedId;
            row.innerHTML = `
                <td class="border px-4 py-2">${selectedName}</td>
                <td class="border px-4 py-2 text-center">
                    <button type="button" onclick="hapusKelas('${selectedId}')" class="text-red-500 hover:underline">Hapus</button>
                </td>
                <input type="hidden" name="kelas_id[]" value="${selectedId}">
            `;
            tabel.appendChild(row);

            // Reset dropdown
            select.selectedIndex = 0;
        }

        function hapusKelas(id) {
            const row = document.getElementById('kelas-row-' + id);
            if (row) row.remove();
        }
    </script>
@endsection
