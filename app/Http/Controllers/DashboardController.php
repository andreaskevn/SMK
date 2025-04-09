<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Kelas};

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::where('id_role', 1)->count();
        $totalGuru = User::where('id_role', 2)->count();
        $totalKelas = Kelas::count();

        // Ambil kelas dengan jumlah siswa terbanyak (top 5)
        $kelas = Kelas::withCount(['users as siswa_count' => function ($query) {
            $query->where('id_role', 1);
        }])
            ->orderByDesc('siswa_count')
            ->take(5)
            ->get();

        $labels = [];
        $siswaData = [];
        $guruData = [];

        foreach ($kelas as $k) {
            $labels[] = $k->kelas_name;
            $siswaData[] = $k->siswa_count;
            $guruData[] = $k->users()->where('id_role', 2)->count();
        }

        return view('dashboard.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'labels',
            'siswaData',
            'guruData'
        ));
    }
}
