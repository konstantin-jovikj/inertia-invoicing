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
            ['regulation' => 'EN 10204:2007', 'description' => 'The standard defines the types of documents that manufacturers must provide to verify product compliance with technical specifications, such as material properties or testing results. It helps ensure traceability, transparency, and quality assurance.'],
            ['regulation' => 'EN IEC 55014-2:2021', 'description' => 'Electromagnetic compatibility - Requirements for household appliances, electric tools and similar apparatus - Part 2: Immunity - Product family standard'],
            ['regulation' => 'EN 61000-3-2', 'description' => 'Electromagnetic compatibility (EMC) – Part 3-2: Limits – Limits for harmonic current emissions (equipment input current ≤ 16 A per phase)'],
            ['regulation' => 'EN 61000-3-3', 'description' => 'Limitation of voltage changes, voltage flucations and flicker in public low-voltage supply systems, for equipment with rated current <16 A per phase and EN 61000-3-11 with rated voltage current <75 a and not subject to conditional connection.'],
            ['regulation' => 'EN 60335-1:2012/A15:2021', 'description' => 'Household and similar electrical appliances - Safety - Part 1: General requirements'],
            ['regulation' => 'EN IEC 60335-2-89:2022', 'description' => 'Household and similar electrical appliances - Safety - Part 2-89: Particular requirements for commercial refrigerating appliances and ice-makers with an incorporated or remote refrigerant unit or motor-compressor'],
            ['regulation' => 'EN 60204-1:2018', 'description' => 'Safety of machinery - Electrical equipment of machines - Part 1: General requirements. applies to electrical, electronic and programmable electronic equipment and systems to machines not portable by hand while working, including a group of machines working together in a co-ordinated manner.'],
            ['regulation' => 'EN ISO 13854:2019', 'description' => 'Safety of machinery - Minimum gaps to avoid crushing of parts of the human body'],
            ['regulation' => 'EN 378', 'description' => 'safety and environmental requirements of refrigerating systems and heat pumps, with an aim of minimising any potential risk of hazards to people and environment, minimising product failures and enhancing the overall operational efficiency of the system'],
            ['regulation' => 'EN 378-2:2016', 'description' => 'Refrigerating systems and heat pumps - Safety and environmental requirements - Part 2: Design, construction, testing, marking and documentation'],
            ['regulation' => 'EN 62233:2008', 'description' => 'Measurement methods for electromagnetic fields of household appliances and similar apparatus with regard to human exposure'],
            ['regulation' => 'EN 50564:2011', 'description' => 'Electrical and electronic household and office equipment - Measurement of low power consumption'],
            ['regulation' => 'EN IEC 63000:2018', 'description' => 'Technical documentation for the assessment of electrical and electronic products with respect to the restriction of hazardous substances'],
            ['regulation' => 'EN 1860-2:2023', 'description' => 'Appliances, solid fuels and firelighters for barbecuing - Part 2: Barbecue charcoal and barbecue charcoal briquettes - Requirements and test methods'],
            ['regulation' => 'EN 16282-1', 'description' => 'Equipment for commercial kitchens - Components for ventilation in commercial kitchens - Part 1: General requirements including calculation method'],

        ];

        // Insert each manufacturer
        foreach ($regulations as $data) {
            Regulation::create($data);
        }
    }
}
