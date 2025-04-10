@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Daftar Siswa</h1>
        <x-buttons.create href="{{ route('siswa.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow inline-flex items-center space-x-2 transition" />
    </div>

    {{-- Filter dan Search --}}
    <form method="GET" action="{{ route('siswa.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Limit tampil per halaman --}}
        <div class="flex flex-col">
            <label for="perPage" class="text-sm text-gray-700 mb-1">Tampilkan per halaman:</label>
            <select name="perPage" id="perPage" onchange="this.form.submit()"
                class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach ([5, 10, 25, 50] as $limit)
                    <option value="{{ $limit }}" {{ request('perPage') == $limit ? 'selected' : '' }}>
                        {{ $limit }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter kelas --}}
        <div class="flex flex-col">
            <label for="kelas_id" class="text-sm text-gray-700 mb-1">Filter berdasarkan Kelas:</label>
            <select name="kelas_id" id="kelas_id" onchange="this.form.submit()" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kelas</option>
                @foreach ($semuaKelas as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->kelas_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="flex flex-col">
            <label for="search" class="text-sm text-gray-700 mb-1">Pencarian Nama/Email:</label>
            <div class="flex">
                <input type="text" name="search" id="search" placeholder="Cari siswa..."
                    value="{{ request('search') }}"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-r-lg transition text-sm">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <x-responsive-table :headers="['Nama Siswa', 'Email', 'Kelas', 'Aksi']" :rows="$siswa
        ->map(
            fn($s) => [
                $s->users_name,
                $s->users_email,
                $s->kelas->pluck('kelas_name')->join(', '),
                view('components.siswa-actions', ['siswa' => $s])->render(),
            ],
        )
        ->toArray()" class="bg-white rounded-lg shadow overflow-hidden" />

    <div class="mt-6">
        {{ $siswa->appends(request()->query())->links() }}
    </div>
@endsection
