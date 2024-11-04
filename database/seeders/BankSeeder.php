<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->delete();

        $banks = array(
            array(
                'name_cyr' => 'Комерцијална банка АД Скопје',
                'name_lat' => 'Komercijalna Banka AD Skopje',
                'address_cyr' => 'ул. Васил Иљоски бр. 3 - Скопје',
                'address_lat' => 'ul. Vasil Iljoski br.3 - Skopje'
            ),
            array(
                'name_cyr' => 'Халк банка АД Скопје',
                'name_lat' => 'Halk Banka Banka AD Skopje',
                'address_cyr' => 'Св. Кирил и Методиј бр.54 - Скопје',
                'address_lat' => 'Sv. Kiril i Metodij br 54 - Skopje'
            ),


        );

        DB::table('banks')->insert($banks);
    }
}
