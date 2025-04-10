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

        $data = [];

        foreach ($kelasList as $name) {
            $data[] = [
                'kelas_name' => $name,
                'kelas_description' => $deskripsi,
                'kelas_capacity' => 30,
                'kelas_code' => Str::upper(Str::random(6)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('kelas')->insert($data);
    }
}
