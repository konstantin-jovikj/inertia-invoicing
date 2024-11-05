<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeclarationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('declarations')->delete();

        $declarations = [
            [
                'title' => 'origin_mk',
                'content' => 'Izvoznikot na proizvodite sto gi pokriva ovoj dokument izjavuva deka, osven ako toa ne  e jasno poinaku naznaceno, deka ovie proizvodi se so MK preferencijalno poteklo.',
            ],
            [
                'title' => 'origin_en',
                'content' => 'The exporter of the products covered by this document declares that, except where otherwise clearly indicated, these products are of MK preferential origin',
            ],
        ];

        DB::table('declarations')->insert($declarations);
    }
}
