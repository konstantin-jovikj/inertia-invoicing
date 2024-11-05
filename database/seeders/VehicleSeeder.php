<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicles')->delete();

        $vehicles = [
            [
                'model' => 'Mercedes Sprinter 313',
                'type' => 'комбе',
                'register_plate_number' => 'GV 3604 AC',
                'max_weight_loaded' => null,
                'max_weight_empty' => null,
                'payload' => null,
            ],
            [
                'model' => 'Mercedes ATEGO',
                'type' => 'камион',
                'register_plate_number' => 'GV 815 CB',
                'max_weight_loaded' => null,
                'max_weight_empty' => null,
                'payload' => null,
            ],
            [
                'model' => 'VW CADDY',
                'type' => 'Пикап',
                'register_plate_number' => 'GV 8213 AD',
                'max_weight_loaded' => null,
                'max_weight_empty' => null,
                'payload' => null,
            ],

        ];
        DB::table('vehicles')->insert($vehicles);
    }
}
