<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Kelas};

class ListController extends Controller
{
    public function index()
    {
        $siswaList = User::where('id_role', 1)->get();
        $guruList = User::where('id_role', 2)->get();
        $kelasList = Kelas::with('users')->get();

        return view('list.tampilan', compact('siswaList', 'guruList', 'kelasList'));
    }
}
