<?php

namespace Database\Seeders;

use App\Models\Directive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directives = [
            ['directive' => '1935/2004', 'description' => 'Materials and articles intended to come into contact with food when placed on the European market.'],
            ['directive' => '2014/30/EU', 'description' => 'Harmonisation of the laws of the Member States relating to electromagnetic compatibility (recast)'],
            ['directive' => '2006/42/EC', 'description' => 'Machinery Directive'],
            ['directive' => '2006/95/EC', 'description' => '(Low Voltage Directive) covers electrical equipment for use at rated voltages between 50 V and 1,000 V for alternating current, and between 75 V and 1,500 V for direct current.'],
            ['directive' => '2014/68/EU', 'description' => 'The Pressure Equipment Directive'],
            ['directive' => '93/68/EEC', 'description' => 'The CE Marking Directive'],
            ['directive' => '2011/65/EU', 'description' => 'The RoHS Directive, also known as the Restriction of Hazardous Substances Directive, is a set of rules that restricts the use of specific hazardous substances in electrical and electronic equipment with the intention of protecting both human health and the environment.'],
            ['directive' => '2012/19/EU', 'description' => 'The purpose of this Directive is, as a first priority, the prevention of waste electrical and electronic equipment (WEEE), and in addition, the reuse, recycling and other forms of recovery of such wastes so as to reduce the disposal of waste.'],
            ['directive' => '2004/108/EC', 'description' => 'The electromagnetic compatibility (EMC) of equipment'],
            ['directive' => '1275/2008', 'description' => ' Ecodesign requirements for standby and off mode, and networked standby, electric power consumption of electrical and electronic household and office equipment'],
            ['directive' => '2016/426', 'description' => 'Appliances burning gaseous fuels'],
            ['directive' => '178/2002', 'description' => 'General principles and requirements of food law, establishing the European Food Safety Authority and laying down procedures in matters of food safety'],
            ['directive' => '517/2014', 'description' => 'Fluorinated greenhouse gases'],
        ];

        // Insert each manufacturer
        foreach ($directives as $data) {
            Directive::create($data);
        }
    }
}
