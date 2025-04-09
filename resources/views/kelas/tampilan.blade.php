@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Kelas</h1>
        <x-buttons.create href="{{ route('kelas.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow inline-flex items-center space-x-2 transition" />
    </div>

    <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center space-x-2">
            <label for="perPage" class="text-sm text-gray-700">Tampilkan:</label>
            <select name="perPage" id="perPage" onchange="this.form.submit()"
                class="border-gray-300 rounded-lg px-3 py-1.5 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach ([5, 10, 25, 50] as $limit)
                    <option value="{{ $limit }}" {{ request('perPage') == $limit ? 'selected' : '' }}>
                        {{ $limit }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex w-full md:w-1/2 space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <button type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                <i data-feather="search" class="w-4 h-4"></i>
                <span>Cari</span>
            </button>
        </div>
    </form>

    <x-responsive-table :headers="['Nama Kelas', 'Jumlah Siswa', 'Jumlah Guru', 'Kode Kelas', 'Status', 'Aksi']" :rows="$kelas
        ->map(
            fn($k) => [
                $k->kelas_name,
                $k->users->where('id_role', 1)->count(),
                $k->users->where('id_role', 2)->count(),
                view('components.status-badge', ['status' => $k->kelas_status])->render(),
                $k->kelas_code,
                view('components.kelas-actions', ['kelas' => $k])->render(),
            ],
        )
        ->toArray()" class="bg-white rounded-lg shadow overflow-hidden" />


    <div class="mt-6">
        {{ $kelas->appends(request()->query())->links() }}
    </div>
@endsection
