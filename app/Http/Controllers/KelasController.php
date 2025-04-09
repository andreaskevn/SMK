<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'kelas_capacity' => 'required|integer',
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

            // Rules utk gambar cover kelas
            'image.required' => 'Cover kelas wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',

            // Rules utk jumlah kapasitas maksimal kelas
            'kelas_capacity.required' => 'Kapasitas kelas wajib diisi.',
            'kelas_capacity.integer' => 'Kapasitas kelas harus berupa angka.',
        ]);
        $kode = Str::upper(Str::random(6));
        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(new Driver());
            $filename = time() . '.webp';
            $image = $manager->read($file)->encode(new WebpEncoder(quality: 80));
            $image->save(public_path('class_cover/' . $filename));
        }
        Kelas::create([
            'kelas_name' => $request->kelas_name,
            'kelas_description' => $request->kelas_description,
            'kelas_cover_header' => $filename,
            'kelas_capacity' => $request->kelas_capacity,
            'kelas_code' => $kode,
            'kelas_status' => 'active',

        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kelas = Kelas::with('users')->findOrFail($id);
        return view('kelas.show', compact('kelas'));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'kelas_name' => 'required|string|max:255|unique:kelas,kelas_name,' . $kelas->id,
            'kelas_description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'kelas_capacity' => 'required|integer',
        ], [
            'kelas_name.required' => 'Nama kelas wajib diisi.',
            'kelas_name.string' => 'Nama kelas harus berupa teks.',
            'kelas_name.max' => 'Nama kelas maksimal 255 karakter.',
            'kelas_name.unique' => 'Nama kelas sudah digunakan.',

            'kelas_description.required' => 'Deskripsi kelas wajib diisi.',
            'kelas_description.string' => 'Deskripsi harus berupa teks.',
            'kelas_description.max' => 'Deskripsi maksimal 255 karakter.',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',

            'kelas_capacity.required' => 'Kapasitas wajib diisi.',
            'kelas_capacity.integer' => 'Kapasitas harus angka.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $manager = new ImageManager(new Driver());
            $filename = time() . '.webp';
            $image = $manager->read($file)->encode(new WebpEncoder(quality: 80));
            $image->save(public_path('class_cover/' . $filename));
            $kelas->kelas_cover_header = $filename;
        }

        $kelas->update([
            'kelas_name' => $request->kelas_name,
            'kelas_description' => $request->kelas_description,
            'kelas_capacity' => $request->kelas_capacity,
            'kelas_status' => 'active',
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'kelas_status' => 'deleted',
        ]);
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
