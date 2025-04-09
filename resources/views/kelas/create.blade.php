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
                <textarea name="kelas_description" id="kelas_description" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Belajar Laravel" rows="4">
                    {{ old('kelas_description') }}
                </textarea>
                @error('kelas_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kelas_capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Maksimal Kelas</label>
                <input type="number" name="kelas_capacity" id="kelas_capacity" value="{{ old('kelas_capacity') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Belajar Laravel">
                @error('kelas_capacity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-full">
                <label for="image" class="block text-sm font-medium text-gray-900">Cover Kelas</label>
                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                    id="drop-area">
                    <div class="text-center">
                        <input id="image" name="image" type="file" class="sr-only" accept="img/*" required>
                        <span id="file-upload-label">Upload a file or drag and drop here</span>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-600">PNG, JPG, up to 5MB</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('kelas.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('image');
        const fileUploadLabel = document.getElementById('file-upload-label');

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('border-indigo-600');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-indigo-600');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('border-indigo-600');
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // Set the file input's files property
                fileUploadLabel.textContent = files[0].name; // Display the file name
            }
        });

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileUploadLabel.textContent = fileInput.files[0].name;
            }
        });
    </script>
@endsection
