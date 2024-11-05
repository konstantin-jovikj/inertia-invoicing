<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('drivers')->delete();

        $drivers = [
            ['name' => 'Буњамин', 'surname' => 'Јашари', 'licence_no' => '', 'personal_id_no' => ''],
            ['name' => 'Иса', 'surname' => 'Јашари', 'licence_no' => '', 'personal_id_no' => ''],
            ['name' => 'Исмет', 'surname' => 'Азизи', 'licence_no' => '', 'personal_id_no' => ''],
            ['name' => 'Али', 'surname' => 'Тиро', 'licence_no' => '', 'personal_id_no' => ''],
            ['name' => 'НЕдим', 'surname' => 'Реџепи', 'licence_no' => '', 'personal_id_no' => ''],
        ];
        DB::table('drivers')->insert($drivers);
    }
}
