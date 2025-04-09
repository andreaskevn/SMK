@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tambah Siswa</h1>
    <form action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Nama</label>
            <input type="text" name="users_name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="users_email" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
    </form>
@endsection
