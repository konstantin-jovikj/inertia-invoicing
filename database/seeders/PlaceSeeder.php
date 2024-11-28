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
            // Italy
            ['country_id' => '28', 'place' => 'Borgo Val Taro', 'zip' => '43043'],
            ['country_id' => '28', 'place' => 'Pavia', 'zip' => '27100'],
            ['country_id' => '28', 'place' => 'Cadoneghe,Padova', 'zip' => '35010'],
            ['country_id' => '28', 'place' => 'Monteroni D`Arbia (Siena)', 'zip' => '53014'],
            ['country_id' => '28', 'place' => 'Conselve (Padova)', 'zip' => '35026'],
            ['country_id' => '28', 'place' => 'Opera,(Milano)', 'zip' => '20090'],
            ['country_id' => '28', 'place' => 'Villa Cortese', 'zip' => '20020'],
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

            // Macedonia
            ['country_id' => '34', 'place' => 'Скопје', 'zip' => '1000'],
            ['country_id' => '34', 'place' => 'Тетово', 'zip' => '1200'],
            ['country_id' => '34', 'place' => 'Gostivar', 'zip' => '1230'],
            ['country_id' => '34', 'place' => 'Битола', 'zip' => '7000'],
            ['country_id' => '34', 'place' => 'Куманово', 'zip' => '1300'],
            ['country_id' => '34', 'place' => 'Прилеп', 'zip' => '7500'],
            ['country_id' => '34', 'place' => 'Велес', 'zip' => '1400'],
            ['country_id' => '34', 'place' => 'Охрид', 'zip' => '6000'],
            ['country_id' => '34', 'place' => 'Штип', 'zip' => '2000'],
            ['country_id' => '34', 'place' => 'Струмица', 'zip' => '2400'],
            ['country_id' => '34', 'place' => 'Кавадарци', 'zip' => '1430'],
            ['country_id' => '34', 'place' => 'Кичево', 'zip' => '6250'],
            ['country_id' => '34', 'place' => 'Струга', 'zip' => '6330'],
            ['country_id' => '34', 'place' => 'Радовиш', 'zip' => '2420'],
            ['country_id' => '34', 'place' => 'Гевгелија', 'zip' => '1480'],
            ['country_id' => '34', 'place' => 'Делчево', 'zip' => '2320'],
            ['country_id' => '34', 'place' => 'Дебар', 'zip' => '1250'],
            ['country_id' => '34', 'place' => 'Ресен', 'zip' => '7310'],
            ['country_id' => '34', 'place' => 'Крива Паланка', 'zip' => '1330'],
            ['country_id' => '34', 'place' => 'Пробиштип', 'zip' => '2210'],
            ['country_id' => '34', 'place' => 'Виница', 'zip' => '2310'],
            ['country_id' => '34', 'place' => 'Берово', 'zip' => '2330'],
            ['country_id' => '34', 'place' => 'Валандово', 'zip' => '2460'],
            ['country_id' => '34', 'place' => 'Богданци', 'zip' => '1484'],
            ['country_id' => '34', 'place' => 'Крушево', 'zip' => '7550'],
            ['country_id' => '34', 'place' => 'Македонски Брод', 'zip' => '6530'],
            ['country_id' => '34', 'place' => 'Демир Хисар', 'zip' => '7240'],
            ['country_id' => '34', 'place' => 'Свети Никол', 'zip' => '2220'],
            ['country_id' => '34', 'place' => 'Неготино', 'zip' => '1440'],
            ['country_id' => '34', 'place' => 'Демир Капија', 'zip' => '1442'],
            ['country_id' => '34', 'place' => 'Македонска Каменица', 'zip' => '2304'],
            ['country_id' => '34', 'place' => 'Пехчево', 'zip' => '2326'],
            ['country_id' => '34', 'place' => 'Дојран', 'zip' => '1487'],

            // Other
            ['country_id' => '22', 'place' => 'Paris', 'zip' => '1600'],
            ['country_id' => '24', 'place' => 'Berlin', 'zip' => '10000'],

        ];

        DB::table('places')->insert($places);
    }
}
