<?php

namespace Database\Seeders;

use App\Models\Refrigerant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefrigerantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Refrigerant::truncate();

        $refrigerants = [
            [
                'short_name' => 'R-134a',
                'synonym' => '1,1,1,2-Tetrafluoroethane HFC-134a',
                'formula' => 'CH2FCF3',
                'gwp' => 1430,
                'boiling_point' => 'at 1 atm (101.3 kPa or 1.013 bar) –15.34 °F (–26.3 °C)',
                'freezing_point' => '–153.9 °F (–103.3 °C)',
                'flammability' => 'The product is not flammable',
                'oxidizing' => 'The product is not oxidizing',
                'vapour_pressure' => 'at 25 °C (77 °F) kPa 666.1 bar 6.661 psia 96.61',
                'relative_density' => '4.24 at 20 °C',
                'other' => '',
            ],

            [
                'short_name' => 'R-404A',
                'synonym' => 'HP62',
                'formula' => 'nearly azeotropic blend of: 52 wt.% R-143a, 44 wt.% R-125, 4 wt.% R-134a.',
                'gwp' => 3922,
                'boiling_point' => '-45,5 °C',
                'freezing_point' => '-117.5 °C',
                'flammability' => 'The product is not flammable',
                'oxidizing' => '',
                'vapour_pressure' => '12 546 hPa at 25 °C, 23 100 hPa at 50 °C',
                'relative_density' => '1,05 g/cm3 at 25 °C, (as liquid)',
                'other' => '',
            ],

            [
                'short_name' => 'R290',
                'synonym' => 'PROPANE - Liquefied Petroleum Gas (LPG)',
                'formula' => 'C3H8',
                'gwp' => 3,
                'boiling_point' => '-43.2°F (-41.79°C)',
                'freezing_point' => '-302.6°F (-185.89°C)',
                'flammability' => 'Extremely flammable in the presence of ignition sources or oxidizing materials',
                'oxidizing' => 'Extremely reactive or incompatible with oxidizing agents',
                'vapour_pressure' => ' at 25°C 853.9 kPa',
                'relative_density' => 'at 25°C 516.1 kg/m3',
                'other' => 'Evaporating temperature:-42.1°C',
            ],

        ];

        foreach ($refrigerants as $data) {
            Refrigerant::create($data);
        }
    }
}

