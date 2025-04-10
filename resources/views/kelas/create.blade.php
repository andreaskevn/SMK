@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Kelas</h1>

        <form method="POST" action="{{ route('kelas.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="kelas_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" name="kelas_name" id="kelas_name" value="{{ old('kelas_name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Belajar Laravel">
                @error('kelas_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kelas_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                <textarea name="kelas_description" id="kelas_description"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Belajar Laravel" rows="4">
                    {{ old('kelas_description') }}
                </textarea>
                @error('kelas_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kelas_capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Maksimal
                    Kelas</label>
                <input type="number" name="kelas_capacity" id="kelas_capacity" value="{{ old('kelas_capacity') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Belajar Laravel">
                @error('kelas_capacity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex justify-end space-x-2">
                <a href="{{ route('kelas.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Simpan</button>
            </div>
        </form>
    </div>
    <script>
    @endsection
