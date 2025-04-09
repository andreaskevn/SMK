<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [
            'Dasar Javascript',
            'Belajar Python',
            'Pemrograman Web',
            'Desain UI/UX',
            'Basis Data',
            'Pemrograman Java',
            'Dasar HTML & CSS',
            'Flutter untuk Pemula',
            'Laravel Lanjut',
            'Analisis Data dengan Excel',
        ];

        $deskripsi = 'Kelas pembelajaran untuk memperdalam topik terkait.';
        $coverList = [
            'cover-js.png',
            'cover-python.png',
            'cover-web.png',
            'cover-uiux.png',
            'cover-db.png',
            'cover-java.png',
            'cover-htmlcss.png',
            'cover-flutter.png',
            'cover-laravel.png',
            'cover-excel.png',
        ];

        $data = [];

        foreach ($kelasList as $index => $name) {
            $data[] = [
                'kelas_name' => $name,
                'kelas_description' => $deskripsi,
                'kelas_cover_header' => $coverList[$index],
                'kelas_capacity' => rand(20, 40),
                'kelas_code' => Str::upper(Str::random(6)),
                'kelas_status' => rand(0, 1) ? 'active' : 'deleted',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('kelas')->insert($data);
    }
}
