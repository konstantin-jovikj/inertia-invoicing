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
            array('type' => 'Понуда'),
            array('type' => 'Про-Фактура'),
            array('type' => 'Фактура'),
            array('type' => 'Авансна Фактура'),
            array('type' => 'Испратница'),
            array('type' => 'Пакинг-Листа'),
            array('type' => 'Каса Прими'),
            array('type' => 'Приемница'),
            array('type' => 'Товарен Лист'),
            array('type' => 'Патен Налог'),
            array('type' => 'Гаранција'),

        );

        DB::table('document_types')->insert($document_types);
    }
}
