<?php

namespace App\Http\Controllers;

use App\Models\{Kelas, User};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 5);

        $query = Kelas::with('users');

        if ($search) {
            $query->where('kelas_name', 'like', "%{$search}%");
        }

        $query->orderBy('created_at', 'desc');
        $kelas = $query->paginate($perPage);

        return view('kelas.tampilan', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_name' => 'required|string|max:255|unique:kelas,kelas_name',
            'kelas_description' => 'required|string|max:255',
            'kelas_capacity' => 'required|integer|min:5|max:30',
        ], [
            // Rules utk nama kelas
            'kelas_name.required' => 'Nama kelas wajib diisi.',
            'kelas_name.string' => 'Nama kelas harus berupa teks.',
            'kelas_name.max' => 'Nama kelas maksimal 255 karakter.',
            'kelas_name.unique' => 'Nama kelas sudah digunakan.',

            // Rules utk deskripsi kelas
            'kelas_description.required' => 'Deskripsi kelas wajib diisi.',
            'kelas_description.string' => 'Deskripsi kelas harus berupa teks.',
            'kelas_description.max' => 'Deskripsi kelas maksimal 255 karakter.',

            // Rules utk jumlah kapasitas maksimal kelas
            'kelas_capacity.required' => 'Kapasitas kelas wajib diisi.',
            'kelas_capacity.integer' => 'Kapasitas kelas harus berupa angka.',
            'kelas_capacity.min' => 'Kapasitas kelas minimal 5.',
            'kelas_capacity.max' => 'Kapasitas kelas maksimal 30.',
        ]);
        $kode = Str::upper(Str::random(6));
        Kelas::create([
            'kelas_name' => $request->kelas_name,
            'kelas_description' => $request->kelas_description,
            'kelas_capacity' => $request->kelas_capacity,
            'kelas_code' => $kode,

        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kelas = Kelas::with(['users' => function ($query) {
            $query->orderBy('id_role', 'desc');
        }])->findOrFail($id);

        return view('kelas.show', compact('kelas'));
    }


    public function edit($id)
    {
        $kelas = Kelas::with('users')->findOrFail($id);
        $guruList = User::where('id_role', 2)->get();
        $siswaList = User::where('id_role', 1)->get();
        return view('kelas.edit', compact('kelas', 'guruList', 'siswaList'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        // Validasi input dasar
        $request->validate([
            'kelas_name' => 'required|string|max:255|unique:kelas,kelas_name,' . $kelas->id,
            'kelas_description' => 'required|string|max:255',
            'kelas_capacity' => 'required|integer|min:5|max:30',
        ], [
            'kelas_name.required' => 'Nama kelas wajib diisi.',
            'kelas_name.string' => 'Nama kelas harus berupa teks.',
            'kelas_name.max' => 'Nama kelas maksimal 255 karakter.',
            'kelas_name.unique' => 'Nama kelas sudah digunakan.',

            'kelas_description.required' => 'Deskripsi kelas wajib diisi.',
            'kelas_description.string' => 'Deskripsi harus berupa teks.',
            'kelas_description.max' => 'Deskripsi maksimal 255 karakter.',

            'kelas_capacity.required' => 'Kapasitas wajib diisi.',
            'kelas_capacity.integer' => 'Kapasitas harus angka.',
            'kelas_capacity.min' => 'Kapasitas minimal 5.',
            'kelas_capacity.max' => 'Kapasitas maksimal 30.',
        ]);

        $data = json_decode($request->input('user_data'), true);

        $jumlahGuru = collect($data)->where('role', 2)->count();
        $jumlahTotal = count($data);

        if ($jumlahGuru > 5) {
            return back()->withErrors(['user_data' => 'Jumlah guru tidak boleh lebih dari 5.'])->withInput();
        }

        if ($jumlahTotal > $request->kelas_capacity) {
            return back()->withErrors(['user_data' => 'Jumlah total pengguna melebihi kapasitas kelas.'])->withInput();
        }

        $kelas->update([
            'kelas_name' => $request->kelas_name,
            'kelas_description' => $request->kelas_description,
            'kelas_capacity' => $request->kelas_capacity,
        ]);

        $kelas->users()->detach();

        foreach ($data as $user) {
            $kelas->users()->attach($user['id']);
        }

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete(); 

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
