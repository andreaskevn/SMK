<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KelasUserSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();
        $kelasIds = DB::table('kelas')->pluck('id')->toArray();

        $data = [];
        $usedCombinations = [];

        while (count($data) < 100) {
            $userId = $userIds[array_rand($userIds)];
            $kelasId = $kelasIds[array_rand($kelasIds)];
            $key = $userId . '-' . $kelasId;

            if (!isset($usedCombinations[$key])) {
                $usedCombinations[$key] = true;

                $data[] = [
                    'user_id' => $userId,
                    'kelas_id' => $kelasId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('kelas_user')->insert($data);
    }
}
