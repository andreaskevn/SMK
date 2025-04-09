<?php

namespace App\Http\Controllers;

use App\Models\{User, Kelas};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function indexSiswa(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('perPage', 5); // default 10
        $kelasId = $request->input('kelas_id');

        $query = User::with('kelas')->where('id_role', 1); // Role guru

        // Filter search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users_name', 'like', "%{$search}%")
                    ->orWhere('users_email', 'like', "%{$search}%");
            });
        }

        // Filter kelas jika dipilih
        if ($kelasId) {
            $query->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            });
        }

        $siswa = $query->paginate($limit)->withQueryString();
        $semuaKelas = \App\Models\Kelas::all(); // Pastikan model Kelas sudah diimport

        return view('siswa.tampilan', compact('siswa', 'search', 'limit', 'semuaKelas'));
    }

    public function createSiswa()
    {
        return view('siswa.create');
    }

    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email',
        ]);

        User::create([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
            'password' => Hash::make('password123'), // password default
            'id_role' => 1, // 1 = siswa
            'users_status' => 'active',
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    // Tampilkan form edit siswa
    public function editSiswa($id)
    {
        $siswa = User::where('id', $id)->where('id_role', 1)->firstOrFail();
        return view('siswa.edit', compact('siswa'));
    }

    // Proses update siswa
    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::where('id', $id)->where('id_role', 1)->firstOrFail();

        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email,' . $siswa->id,
        ]);

        $siswa->update([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroySiswa($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->update([
            'users_status' => 'deleted',
        ]);
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }


    public function indexGuru(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('perPage', 5); // default 10
        $kelasId = $request->input('kelas_id');

        $query = User::with('kelas')->where('id_role', 2); // Role guru

        // Filter search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users_name', 'like', "%{$search}%")
                    ->orWhere('users_email', 'like', "%{$search}%");
            });
        }

        // Filter kelas jika dipilih
        if ($kelasId) {
            $query->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            });
        }

        $guru = $query->paginate($limit)->withQueryString();
        $semuaKelas = \App\Models\Kelas::all(); // Pastikan model Kelas sudah diimport

        return view('guru.tampilan', compact('guru', 'search', 'limit', 'semuaKelas'));
    }


    public function createGuru()
    {
        return view('guru.create');
    }

    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email',
        ]);

        User::create([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
            'password' => Hash::make('password123'), // password default
            'id_role' => 2, // 2 = guru
            'users_status' => 'active',
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    // Tampilkan form edit guru
    public function editGuru($id)
    {
        $guru = User::where('id', $id)->where('id_role', 2)->firstOrFail(); // 2 = guru
        return view('guru.edit', compact('guru'));
    }

    // Proses update guru
    public function updateGuru(Request $request, $id)
    {
        $guru = User::where('id', $id)->where('id_role', 2)->firstOrFail();

        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email,' . $guru->id,
        ]);

        $guru->update([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    public function destroyGuru($id)
    {
        $guru = User::findOrFail($id);
        $guru->update([
            'users_status' => 'deleted',
        ]);
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
