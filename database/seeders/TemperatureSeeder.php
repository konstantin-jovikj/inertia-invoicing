<?php

namespace Database\Seeders;

use App\Models\Temperature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemperatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temperature::truncate();

        $temperatures = [
            ['class' => 'M0', 'range' => '-1°C / +4°C'],
            ['class' => 'M1', 'range' => '-1°C / +5°C'],
            ['class' => 'M2', 'range' => '-1°C / +7°C'],
            ['class' => 'H1', 'range' => '+1°C / +10°C'],
            ['class' => 'H2', 'range' => '-1°C / +10°C'],
            ['class' => 'L1', 'range' => '-15°C / -18°C'],
            ['class' => 'L2', 'range' => '-12°C / -18°C'],
            ['class' => 'L3', 'range' => '-12°C / -15°C'],
            ['class' => 'G1', 'range' => '-10°C / -14°C'],
            ['class' => 'G3', 'range' => '-10°C / -18°C'],
        ];

        // Insert each manufacturer
        foreach ($temperatures as $data) {
            Temperature::create($data);
        }
    }
}
