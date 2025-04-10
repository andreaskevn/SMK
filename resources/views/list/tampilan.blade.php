@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Daftar Guru</h2>
    <table class="w-full mb-8 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guruList as $guru)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $guru->users_name }}</td>
                    <td class="px-4 py-2">{{ $guru->users_email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mb-4">Daftar Siswa</h2>
    <table class="w-full mb-8 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswaList as $siswa)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $siswa->users_name }}</td>
                    <td class="px-4 py-2">{{ $siswa->users_email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mb-4">Daftar Kelas</h2>
    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Nama Kelas</th>
                <th class="px-4 py-2 text-left">Kapasitas</th>
                <th class="px-4 py-2 text-left">Jumlah Pengguna</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelasList as $kelas)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $kelas->kelas_name }}</td>
                    <td class="px-4 py-2">{{ $kelas->kelas_capacity }}</td>
                    <td class="px-4 py-2">{{ $kelas->users->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
