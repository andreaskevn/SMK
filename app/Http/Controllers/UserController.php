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
        $limit = $request->input('perPage', 5);
        $kelasId = $request->input('kelas_id');

        $query = User::with('kelas')->where('id_role', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users_name', 'like', "%{$search}%")
                    ->orWhere('users_email', 'like', "%{$search}%");
            });
        }

        if ($kelasId) {
            $query->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            });
        }
        $query->orderBy('created_at', 'desc');
        $siswa = $query->paginate($limit)->withQueryString();
        $semuaKelas = Kelas::all();

        return view('siswa.tampilan', compact('siswa', 'search', 'limit', 'semuaKelas'));
    }

    public function createSiswa()
    {
        $kelasList = Kelas::withCount([
            'users as total_guru' => function ($query) {
                $query->where('id_role', 2);
            },
            'users as total_murid' => function ($query) {
                $query->where('id_role', '!=', 2);
            }

        ])->get();
        return view('siswa.create', compact('kelasList'));
    }

    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:kelas,id',
        ], [
            'users_name.required' => 'Nama harus diisi',
            'users_email.required' => 'Email harus diisi',
            'users_email.email' => 'Format email tidak valid',
            'users_email.unique' => 'Email sudah terdaftar',
            'kelas_id.required' => 'Minimal harus mengikuti satu kelas.',
            'kelas_id.*.exists' => 'Kelas tidak ditemukan',
        ]);

        foreach ($request->kelas_id as $kelasId) {
            $kelas = Kelas::withCount([
                'users as total_guru' => fn($q) => $q->where('id_role', 2),
                'users as total_murid' => fn($q) => $q->where('id_role', '!=', 2),
            ])->find($kelasId);

            if (!$kelas) {
                return back()->withErrors(['kelas_id' => 'Kelas tidak ditemukan']);
            }

            if ($kelas->total_guru >= 5) {
                return back()->withErrors(['kelas_id' => "Kelas {$kelas->kelas_name} sudah penuh untuk guru"]);
            }

            if (($kelas->total_guru + $kelas->total_murid) >= 30) {
                return back()->withErrors(['kelas_id' => "Kelas {$kelas->kelas_name} sudah penuh total kapasitas"]);
            }
        }


        $siswa = User::create([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
            'password' => Hash::make('password123'),
            'id_role' => 1, // 2 = guru
            'users_status' => 'active',
        ]);
        $siswa->kelas()->attach($request->kelas_id);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function editSiswa($id)
    {
        $kelasList = Kelas::withCount([
            'users as total_guru' => function ($query) {
                $query->where('id_role', 2);
            },
            'users as total_murid' => function ($query) {
                $query->where('id_role', '!=', 2);
            }

        ])->get();
        $siswa = User::where('id', $id)->where('id_role', 1)->firstOrFail();
        return view('siswa.edit', compact('siswa', 'kelasList'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::where('id', $id)->where('id_role', 1)->firstOrFail();

        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email,' . $siswa->id,
            'kelas_id' => 'array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        $siswa->update([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
        ]);

        if ($request->has('kelas_id')) {
            $siswa->kelas()->sync($request->kelas_id);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function destroySiswa($id)
    {
        $siswa = User::where('id_role', 1)->findOrFail($id);
        $siswa->delete(); // Ini akan mengisi kolom deleted_at
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus (soft delete).');
    }


    public function indexGuru(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('perPage', 5);
        $kelasId = $request->input('kelas_id');

        $query = User::with('kelas')
            ->where('id_role', 2);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users_name', 'like', "%{$search}%")
                    ->orWhere('users_email', 'like', "%{$search}%");
            });
        }

        if ($kelasId) {
            $query->whereHas('kelas', function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            });
        }
        $query->orderBy('created_at', 'desc');
        $guru = $query->paginate($limit)->withQueryString();
        $semuaKelas = \App\Models\Kelas::all();

        return view('guru.tampilan', compact('guru', 'search', 'limit', 'semuaKelas'));
    }


    public function createGuru()
    {
        $kelasList = Kelas::withCount([
            'users as total_guru' => function ($query) {
                $query->where('id_role', 2);
            },
            'users as total_murid' => function ($query) {
                $query->where('id_role', '!=', 2);
            }

        ])->get();
        return view('guru.create', compact('kelasList'));
    }

    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        foreach ($request->kelas_id as $kelasId) {
            $kelas = Kelas::withCount([
                'users as total_guru' => fn($q) => $q->where('id_role', 2),
                'users as total_murid' => fn($q) => $q->where('id_role', '!=', 2),
            ])->find($kelasId);

            if (!$kelas) {
                return back()->withErrors(['kelas_id' => 'Kelas tidak ditemukan']);
            }

            if ($kelas->total_guru >= 5) {
                return back()->withErrors(['kelas_id' => "Kelas {$kelas->kelas_name} sudah penuh untuk guru"]);
            }

            if (($kelas->total_guru + $kelas->total_murid) >= 30) {
                return back()->withErrors(['kelas_id' => "Kelas {$kelas->kelas_name} sudah penuh total kapasitas"]);
            }
        }


        $guru = User::create([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
            'password' => Hash::make('password123'),
            'id_role' => 2, // 2 = guru
            'users_status' => 'active',
        ]);
        $guru->kelas()->attach($request->kelas_id);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function editGuru($id)
    {
        $kelasList = Kelas::withCount([
            'users as total_guru' => function ($query) {
                $query->where('id_role', 2);
            },
            'users as total_murid' => function ($query) {
                $query->where('id_role', '!=', 2);
            }
        ])->get();
        $guru = User::where('id', $id)->where('id_role', 2)->firstOrFail();
        return view('guru.edit', compact('guru', 'kelasList'));
    }

    // Proses update guru
    public function updateGuru(Request $request, $id)
    {
        $guru = User::where('id', $id)->where('id_role', 2)->firstOrFail();

        $validated = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => 'required|email|unique:users,users_email,' . $guru->id,
            'kelas_id' => 'array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        // Update data user
        $guru->update([
            'users_name' => $validated['users_name'],
            'users_email' => $validated['users_email'],
        ]);

        // Update relasi kelas (jika ada)
        if ($request->has('kelas_id')) {
            // Asumsinya relasi many-to-many antara users dan kelas
            $guru->kelas()->sync($request->kelas_id);
        }

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    public function destroyGuru($id)
    {
        $guru = User::where('id_role', 2)->findOrFail($id);
        $guru->delete(); // Ini akan mengisi kolom deleted_at
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus (soft delete).');
    }
}
