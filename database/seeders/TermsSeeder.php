<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->delete();

        $terms = [
            [
                'term' => 'Avansno',
            ],
            [
                'term' => 'Авансно',
            ],
            [
                'term' => 'Во Готово',
            ],
            [
                'term' => '50% Авансно и 50% пред испорака',
            ],
            [
                'term' => '50% Avansno и 50% pred Isporaka',
            ],
            [
                'term' => '50% In Advance and 50% before Delivery',
            ],
        ];

        DB::table('terms')->insert($terms);
    }
}
