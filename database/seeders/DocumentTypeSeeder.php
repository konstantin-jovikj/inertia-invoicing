<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('document_types')->delete();

        $document_types = array(
            array('type' => 'Offer'),
            array('type' => 'Proforma-Invoice'),
            array('type' => 'Invoice'),
            array('type' => 'Ispratnica'),
            array('type' => 'Сметко Потврда'),
            array('type' => 'Priemnica'),
            array('type' => 'Tovaren List'),
        );

        DB::table('document_types')->insert($document_types);
    }
}
