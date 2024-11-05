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

        $places = [
            // Macedonia
            ['country_id' => '35', 'place' => 'Скопје', 'zip' => '1000'],
            ['country_id' => '35', 'place' => 'Тетово', 'zip' => '1220'],
            ['country_id' => '35', 'place' => 'Гостивар', 'zip' => '1230'],

                // Other
            ['country_id' => '22', 'place' => 'Paris', 'zip' => '1600'],
            ['country_id' => '24', 'place' => 'Berlin', 'zip' => '10000'],
                // Italy
            ['country_id' => '28', 'place' => 'Borgo Val Taro', 'zip' => '43043'],
            ['country_id' => '28', 'place' => 'Pavia', 'zip' => '27100'],
            ['country_id' => '28', 'place' => 'Cadoneghe,Padova', 'zip' => '35010'],
            ['country_id' => '28', 'place' => 'Monteroni D`Arbia (Siena)', 'zip' => '53014'],
            ['country_id' => '28', 'place' => 'Conselve (Padova)', 'zip' => '35026'],
            ['country_id' => '28', 'place' => 'Opera,(Milano)', 'zip' => '20090'],
            ['country_id' => '28', 'place' => 'Villa Coftese', 'zip' => '20020'],
            ['country_id' => '28', 'place' => 'Castelfranco Veneto (TV)', 'zip' => '31033'],
            ['country_id' => '28', 'place' => 'Suzzara (MN)', 'zip' => '46029'],
            ['country_id' => '28', 'place' => 'Torino', 'zip' => '10141'],
            ['country_id' => '28', 'place' => 'Villa Verucchio (RN)', 'zip' => '47826'],
            ['country_id' => '28', 'place' => 'Albano Laziale (RM)', 'zip' => '00041'],
            ['country_id' => '28', 'place' => 'Montemurlo (PO)', 'zip' => '59013'],
            ['country_id' => '28', 'place' => 'Vallà di Riese Pio X (TV)', 'zip' => '31033'],
            ['country_id' => '28', 'place' => 'Mareno DiPiave', 'zip' => '31010'],
            ['country_id' => '28', 'place' => 'Biasonno', 'zip' => '20853'],
            ['country_id' => '28', 'place' => 'Pederobba (TV)', 'zip' => '31040'],
            ['country_id' => '28', 'place' => 'Valvasone (PN)', 'zip' => '33098'],
            ['country_id' => '28', 'place' => 'Urbino (PU)', 'zip' => '61029'],
            ['country_id' => '28', 'place' => 'Lumezzane(BS)', 'zip' => '25065'],
            ['country_id' => '28', 'place' => 'Zane (VI)', 'zip' => '36010'],
            ['country_id' => '28', 'place' => 'Ascoli Piceno (AP)', 'zip' => '63100'],
            ['country_id' => '28', 'place' => 'Pogliano Milenese', 'zip' => '20010'],
            ['country_id' => '28', 'place' => 'Pieve di Curtarolo', 'zip' => '35010'],
            ['country_id' => '28', 'place' => 'Cadoneghe (PD)', 'zip' => '35010'],

        ];

        DB::table('places')->insert($places);
    }
}
