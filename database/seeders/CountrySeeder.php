<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();

        $countries = array(
            array('code' => 'US', 'name' => 'United States'),
            array('code' => 'CA', 'name' => 'Canada'),
            array('code' => 'AL', 'name' => 'Albania'),
            array('code' => 'AR', 'name' => 'Argentina'),
            array('code' => 'AM', 'name' => 'Armenia'),
            array('code' => 'AU', 'name' => 'Australia'),
            array('code' => 'AT', 'name' => 'Austria'),
            array('code' => 'AZ', 'name' => 'Azerbaijan'),
            array('code' => 'BY', 'name' => 'Belarus'),
            array('code' => 'BE', 'name' => 'Belgium'),
            array('code' => 'BA', 'name' => 'Bosnia and Herzegovina'),
            array('code' => 'BR', 'name' => 'Brazil'),
            array('code' => 'BG', 'name' => 'Bulgaria'),
            array('code' => 'CN', 'name' => 'China'),
            array('code' => 'KM', 'name' => 'Comoros'),
            array('code' => 'HR', 'name' => 'Croatia (Hrvatska)'),
            array('code' => 'CY', 'name' => 'Cyprus'),
            array('code' => 'CZ', 'name' => 'Czech Republic'),
            array('code' => 'DK', 'name' => 'Denmark'),
            array('code' => 'EE', 'name' => 'Estonia'),
            array('code' => 'FI', 'name' => 'Finland'),
            array('code' => 'FR', 'name' => 'France'),
            array('code' => 'GE', 'name' => 'Georgia'),
            array('code' => 'DE', 'name' => 'Germany'),
            array('code' => 'GR', 'name' => 'Greece'),
            array('code' => 'HU', 'name' => 'Hungary'),
            array('code' => 'IE', 'name' => 'Ireland'),
            array('code' => 'IT', 'name' => 'Italy'),
            array('code' => 'LI', 'name' => 'Liechtenstein'),
            array('code' => 'LU', 'name' => 'Luxembourg'),
            array('code' => 'MT', 'name' => 'Malta'),
            array('code' => 'NL', 'name' => 'Netherlands'),
            array('code' => 'NZ', 'name' => 'New Zealand'),
            array('code' => 'MK', 'name' => 'R.N.Macedonia'),
            array('code' => 'NO', 'name' => 'Norway'),
            array('code' => 'PL', 'name' => 'Poland'),
            array('code' => 'PT', 'name' => 'Portugal'),
            array('code' => 'RO', 'name' => 'Romania'),
            array('code' => 'RU', 'name' => 'Russian Federation'),
            array('code' => 'RS', 'name' => 'Serbia'),
            array('code' => 'SK', 'name' => 'Slovakia'),
            array('code' => 'SI', 'name' => 'Slovenia'),
            array('code' => 'ES', 'name' => 'Spain'),
            array('code' => 'SE', 'name' => 'Sweden'),
            array('code' => 'CH', 'name' => 'Switzerland'),
            array('code' => 'TR', 'name' => 'Turkey'),
            array('code' => 'GB', 'name' => 'United Kingdom'),
        );

        DB::table('countries')->insert($countries);
    }
}
