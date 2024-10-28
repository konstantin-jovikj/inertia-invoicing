<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('places')->delete();

        $places = array(
            array('country_id' => '35', 'place' => 'Скопје', 'zip' => '1000'),
            array('country_id' => '35', 'place' => 'Тетово', 'zip' => '1220'),
            array('country_id' => '35', 'place' => 'Гостивар', 'zip' => '1230'),
            array('country_id' => '22', 'place' => 'Paris', 'zip' => '1600'),
            array('country_id' => '24', 'place' => 'Berlin', 'zip' => '10000'),

        );

        DB::table('places')->insert($places);
    }
}
