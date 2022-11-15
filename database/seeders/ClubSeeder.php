<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = [
          ['code' => 'DFEC', 'name' => 'Dodiongan Falls Eagles Club'],
          ['code' => 'MAAEC', 'name' => 'Mount Agad-Agad Eagles Club'],
          ['code' => 'MREC', 'name' => 'Mandulog River Eagles Club'],
          ['code' => 'GFEC', 'name' => 'Green Forest Eagles Club'],
          ['code' => 'TFEC', 'name' => 'Talacogon Falls Eagles Club'],
          ['code' => 'FNEC', 'name' => 'Friendly Naawan Eagles Club'],
          ['code' => 'MEC', 'name' => 'Manticao Eagles Club'],
          ['code' => 'INLEC', 'name' => 'Iligan North Lady Eagles Club'],
          ['code' => 'RMLEC', 'name' => 'Red Mountain Lady Eagles Club']
        ];
        DB::table('clubs')->insert($clubs);
    }
}
