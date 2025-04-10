@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Kelas</h1>

        <form method="POST" action="{{ route('kelas.update', $kelas->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="kelas_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" name="kelas_name" id="kelas_name" value="{{ old('kelas_name', $kelas->kelas_name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('kelas_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kelas_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                <textarea name="kelas_description" id="kelas_description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('kelas_description', $kelas->kelas_description) }}</textarea>
                @error('kelas_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kelas_capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                <input type="number" name="kelas_capacity" id="kelas_capacity"
                    value="{{ old('kelas_capacity', $kelas->kelas_capacity) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('kelas_capacity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kelas_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Kelas</label>
                <input type="text" name="kelas_code" id="kelas_code" value="{{ old('kelas_code', $kelas->kelas_code) }}"
                    readonly
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tambah Guru atau Siswa</label>
                <div class="flex space-x-2 mt-1">
                    <select id="userSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                        <option value="">-- Pilih Guru atau Siswa --</option>
                        @foreach ($guruList as $guru)
                            <option value="1-{{ $guru->id }}">{{ $guru->users_name }} (Guru)</option>
                        @endforeach
                        @foreach ($siswaList as $siswa)
                            <option value="2-{{ $siswa->id }}">{{ $siswa->users_name }} (Siswa)</option>
                        @endforeach
                    </select>
                    <button type="button" id="btnTambahUser" onclick="tambahUser()"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 disabled:opacity-50 disabled:cursor-not-allowed">
                        Tambah
                    </button>
                    <p id="warningCapacity" class="text-sm text-red-500 mt-1 hidden">Kapasitas kelas sudah penuh.</p>
                </div>
            </div>

            <div class="mt-4">
                <table class="w-full text-left border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTable"></tbody>
                </table>
            </div>

            <!-- Hidden input untuk data dikirim saat submit -->
            <input type="hidden" name="user_data" id="userData">

            <div class="flex justify-end space-x-2">
                <a href="{{ route('kelas.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Perbarui</button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        // Data user yang sudah tergabung dalam kelas
        let userList = @json($kelas->users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->users_name,
                'role' => $user->id_role
            ];
        }));

        const kapasitas = {{ $kelas->kelas_capacity }};

        function tambahUser() {
            const select = document.getElementById('userSelect');
            const value = select.value;
            if (!value) return;

            const [role, id] = value.split('-');
            const name = select.options[select.selectedIndex].text;

            // Cek duplikat
            const isDuplicate = userList.find(u => u.id == id && u.role == role);
            if (isDuplicate) {
                alert("User ini sudah ditambahkan.");
                return;
            }

            const guruCount = userList.filter(u => u.role == 2).length;
            const siswaCount = userList.filter(u => u.role == 1).length;

            if (role == 2 && guruCount >= 5) {
                alert("Maksimal hanya 5 guru.");
                return;
            }

            if (role == 1 && (guruCount + siswaCount) >= kapasitas) {
                document.getElementById('warningCapacity').classList.remove('hidden');
                return;
            } else {
                document.getElementById('warningCapacity').classList.add('hidden');
            }

            userList.push({
                id,
                name,
                role
            });

            renderTable();
        }

        function hapusUser(index) {
            userList.splice(index, 1);
            renderTable();
        }

        function renderTable() {
            const table = document.getElementById('userTable');
            table.innerHTML = '';

            userList.forEach((user, index) => {
                const roleWord = user.role == 1 ? 'Guru' : 'Siswa';

                table.innerHTML += `
                    <tr class="border-t">
                        <td class="px-4 py-2">${user.name}</td>
                        <td class="px-4 py-2">${roleWord}</td>
                        <td class="px-4 py-2">
                            <button type="button" onclick="hapusUser(${index})"
                                class="text-red-500 hover:underline">Hapus</button>
                        </td>
                    </tr>`;
            });

            document.getElementById('userData').value = JSON.stringify(userList);
        }

        // Render saat halaman dimuat
        renderTable();
    </script>
@endsection
