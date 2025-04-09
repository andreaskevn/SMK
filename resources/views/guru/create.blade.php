@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Guru</h1>

        <form method="POST" action="{{ route('guru.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="users_name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="users_name" id="users_name" value="{{ old('users_name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Budi Santoso" required>
                @error('users_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="users_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="users_email" id="users_email" value="{{ old('users_email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: budi@example.com" required>
                @error('users_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('guru.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Simpan</button>
            </div>
        </form>
    </div>
@endsection
