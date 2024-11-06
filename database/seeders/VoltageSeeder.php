<?php

namespace Database\Seeders;

use App\Models\Voltage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoltageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Voltage::truncate();

        $voltages = [
            ['voltage' => '230 V AC 50 Hz 1-phase'], // Common in Europe and other regions
            ['voltage' => '400 V AC 50 Hz 3-phase'], // Standard 3-phase voltage in Europe
        ];

        // Insert each manufacturer
        foreach ($voltages as $data) {
            Voltage::create($data);
        }
    }
}
