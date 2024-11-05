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
            ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro'],
            ['code' => 'USD', 'symbol' => '$', 'name' => 'Dollar'],
            ['code' => 'MKD', 'symbol' => 'ден', 'name' => 'Macedonian Denar'],
        ];
        DB::table('curencies')->insert($curencies);
    }
}