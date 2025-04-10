@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data Guru</h1>

        <form method="POST" action="{{ route('guru.update', $guru->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="users_name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="users_name" id="users_name" value="{{ old('users_name', $guru->users_name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Budi Santoso" required>
                @error('users_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="users_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="users_email" id="users_email"
                    value="{{ old('users_email', $guru->users_email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: budi@example.com" required>
                @error('users_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

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
                                    {{ $kelas->kelas_name }} (Sisa Guru: {{ $sisaGuru }} | Sisa Total:
                                    {{ $sisaTotal }})
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
            <div>
                <table class="w-full mt-4 border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Kelas</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_kelas">
                        @foreach ($guru->kelas as $kelas)
                            <tr id="kelas-row-{{ $kelas->id }}">
                                <td class="border px-4 py-2">{{ $kelas->kelas_name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <button type="button" onclick="hapusKelas('{{ $kelas->id }}')"
                                        class="text-red-500 hover:underline">Hapus</button>
                                </td>
                                <input type="hidden" name="kelas_id[]" value="{{ $kelas->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('guru.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Perbarui</button>
            </div>
        </form>
    </div>
    <script>
        function tambahKelas() {
            const select = document.getElementById('kelas_select');
            const selectedId = select.value;
            const selectedName = select.options[select.selectedIndex].dataset.name;

            if (!selectedId) return;

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

            select.selectedIndex = 0;
        }

        function hapusKelas(id) {
            const row = document.getElementById('kelas-row-' + id);
            if (row) row.remove();
        }
    </script>
@endsection
