<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taxes')->delete();

        $taxes = [
            ['tax_rate' => 5.00],
            ['tax_rate' => 18.00],
        ];

        DB::table('taxes')->insert($taxes);
    }
}
