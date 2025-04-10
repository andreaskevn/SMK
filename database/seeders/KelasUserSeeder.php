<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KelasUserSeeder extends Seeder
{
    public function run(): void
    {
        $guruIds = DB::table('users')->where('id_role', 2)->pluck('id')->toArray();
        $muridIds = DB::table('users')->where('id_role', '!=', 2)->pluck('id')->toArray();
        $kelasIds = DB::table('kelas')->pluck('id')->toArray();

        $data = [];
        $usedCombinations = [];

        foreach ($kelasIds as $kelasId) {
            $usedGuru = [];
            $usedMurid = [];

            // Maksimal 5 guru
            shuffle($guruIds);
            for ($i = 0; $i < min(5, count($guruIds)); $i++) {
                $userId = $guruIds[$i];
                $key = $userId . '-' . $kelasId;

                if (!isset($usedCombinations[$key])) {
                    $usedCombinations[$key] = true;
                    $usedGuru[] = $userId;

                    $data[] = [
                        'user_id' => $userId,
                        'kelas_id' => $kelasId,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            // Sisa kapasitas untuk murid
            $sisa = 30 - count($usedGuru);
            shuffle($muridIds);

            for ($i = 0; $i < min($sisa, count($muridIds)); $i++) {
                $userId = $muridIds[$i];
                $key = $userId . '-' . $kelasId;

                if (!isset($usedCombinations[$key])) {
                    $usedCombinations[$key] = true;
                    $usedMurid[] = $userId;

                    $data[] = [
                        'user_id' => $userId,
                        'kelas_id' => $kelasId,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        DB::table('kelas_user')->insert($data);
    }
}
