<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('curencies')->delete();

        $curencies = [
            ['code' => 'MKD', 'symbol' => 'ден', 'name' => 'Macedonian Denar'],
            ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro'],
            ['code' => 'USD', 'symbol' => '$', 'name' => 'Dollar'],
        ];
        DB::table('curencies')->insert($curencies);
    }
}
