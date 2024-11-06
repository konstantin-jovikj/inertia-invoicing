<?php

namespace Database\Seeders;

use App\Models\Regulation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Regulation::truncate();

        $regulations = [
            ['regulation' => '(EC) No 1935/2004', 'description' => 'materials and articles intended to come into contact with food when placed on the European market.'],

        ];

        // Insert each manufacturer
        foreach ($regulations as $data) {
            Regulation::create($data);
        }
    }
}
