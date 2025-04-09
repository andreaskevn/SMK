@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Kelas: {{ $kelas->kelas_name }}</h1>

        <div class="mb-6 space-y-2">
            <p><strong>Deskripsi:</strong> {{ $kelas->kelas_description }}</p>
            <p><strong>Kapasitas:</strong> {{ $kelas->kelas_capacity }} siswa</p>
            <p><strong>Jumlah Pengguna Saat Ini:</strong> {{ $kelas->users->count() }}</p>
        </div>

        <h2 class="text-xl font-semibold mb-4">Daftar Pengguna</h2>

        @php
            $headers = ['Nama', 'Email', 'Role'];
            $rows = $kelas->users->map(function ($user) {
                return [e($user->users_name), e($user->users_email), e($user->roles->roles_name)];
            });
        @endphp

        <x-responsive-table :headers="$headers" :rows="$rows" />
        <div class="mt-6">
            <a href="{{ route('kelas.index') }}"
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
