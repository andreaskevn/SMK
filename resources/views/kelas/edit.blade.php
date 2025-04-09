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



            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Cover Kelas</label>
                @if ($kelas->kelas_cover_header)
                    <img src="{{ asset('class_cover/' . $kelas->kelas_cover_header) }}" alt="Cover Lama"
                        class="w-40 h-auto mb-2">
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('kelas.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Perbarui</button>
            </div>
        </form>
    </div>
@endsection
