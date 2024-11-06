<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manufacturer;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing records
        Manufacturer::truncate();

        // Define the manufacturers to insert
        $manufacturers = [
            ['place_id' => 1, 'address' => 'Via S.Domenico no.2', 'name' => 'Aexperial S-A.S'],
            ['place_id' => 2, 'address' => 'Via Olevano no.59', 'name' => 'Agrindustria-plast SRL'],
            ['place_id' => 3, 'address' => 'Via G.B. Tiepolo no.3/B', 'name' => 'Arris Catering Equipment S.r.L'],
            ['place_id' => 4, 'address' => 'Via di Collandino no.190', 'name' => 'ASIT srl'],
            ['place_id' => 5, 'address' => 'Viale Del Progresso no.20', 'name' => 'A.T.A. srl'],
            ['place_id' => 6, 'address' => 'Via dei Pioppi no.33', 'name' => 'BRAS INTERNAZIONALE s.p.a'],
            ['place_id' => 7, 'address' => 'Via Dell industria no.10', 'name' => 'Brema ice Makers SPA'],
            ['place_id' => 8, 'address' => 'Via dei Lavoro no.9', 'name' => 'Castel Mac srl'],
            ['place_id' => 9, 'address' => 'S.S. Cisa km no.161', 'name' => 'EVERLASTING S.R.L'],
            ['place_id' => 10, 'address' => 'Fia Fabbriche no.11 c', 'name' => 'FACEM s.p.a'],
            ['place_id' => 11, 'address' => 'Via S.Pertini 29', 'name' => 'Fimar s.p.a'],
            ['place_id' => 11, 'address' => 'Via S.Pertini 14', 'name' => 'Forcar s.p.a'],
            ['place_id' => 12, 'address' => 'Via dei Tulipani, 46', 'name' => 'Genus Dei Srl'],
            ['place_id' => 13, 'address' => 'Via Popolesco 58', 'name' => 'GI.METAL S.r.L'],
            ['place_id' => 14, 'address' => 'Via Kennedy no.60', 'name' => 'Lame ltalia SRL'],
            ['place_id' => 15, 'address' => 'Via Conti Agosti no.231', 'name' => 'Mareno Industrie Ali S.p.a'],
            ['place_id' => 16, 'address' => 'Via Brenno no.21', 'name' => 'Omniwash Srl'],
            ['place_id' => 17, 'address' => 'Zona Industriale 59', 'name' => 'Patrix Srl'],
            ['place_id' => 18, 'address' => 'Via Tabina no.18', 'name' => 'Primasfood Srl'],
            ['place_id' => 19, 'address' => 'Via del Lavoro no.4', 'name' => 'RESTO - TECNO A SRL'],
            ['place_id' => 20, 'address' => 'Via Ruca no.82', 'name' => 'Risoli Srl'],
            ['place_id' => 21, 'address' => 'Via Vegri no.83', 'name' => 'RONDA S.P.A'],
            ['place_id' => 22, 'address' => 'Zona Industriale Campolungo no.79/81', 'name' => 'SAGI S.P.A'],
            ['place_id' => 23, 'address' => 'Via Paskoli no.22', 'name' => 'SIMAG'],
            ['place_id' => 24, 'address' => 'Viale Dell industria no.9/11', 'name' => 'Sirman S.P.A'],
            ['place_id' => 25, 'address' => 'Via Maiorana no.22', 'name' => 'UNOX S.P.A'],
        ];

        // Insert each manufacturer
        foreach ($manufacturers as $data) {
            Manufacturer::create($data);
        }
    }
}
