<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('customer_types')->delete();

        $types = array(
            array('type' => 'Физичко Лице'),
            array('type' => 'Правно Лице'),
        );

        DB::table('customer_types')->insert($types);
    }
}
