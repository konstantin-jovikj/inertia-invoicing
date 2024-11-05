<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncotermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incoterms')->delete();

        $incoterms = array(
            array(
                'shortcut' => 'ExWorks',
                'short_description' => 'EXW – Ex-Works  or Ex-Warehouse',
                'description' => 'Ex works is when the seller places the goods at the disposal of the buyer at the seller’s premises or at another named place (i.e., works, factory, warehouse, etc.).
The seller does not need to load the goods on any collecting vehicle. Nor does it need to clear them for export, where such clearance is applicable.'
            ),

            array(
                'shortcut' => 'DAP',
                'short_description' => 'Delivered At Place',
                'description' => 'The seller delivers when the goods are placed at the disposal of the buyer on the arriving means of transport ready for unloading at the named place of destination.
The seller bears all risks involved in bringing the goods to the named place.'
            ),

            array(
                'shortcut' => 'FCA',
                'short_description' => 'Free Carrier',
                'description' => 'The seller delivers the goods to the carrier or another person nominated by the buyer at the seller’s premises or another named place.
The parties are well advised to specify as explicitly as possible the point within the named place of delivery, as the risk passes to the buyer at that point.
2020 Update: Allows for the issuance of a Bill of Lading with an onboard notation.'
            ),

            array(
                'shortcut' => 'FAS',
                'short_description' => 'Free Alongside Ship',
                'description' => 'The seller delivers when the goods are placed alongside the vessel (e.g., on a quay or a barge) nominated by the buyer at the named port of shipment.
The risk of loss of or damage to the goods passes when the products are alongside the ship.  The buyer bears all costs from that moment onwards.'
            ),

            array(
                'shortcut' => 'FOB',
                'short_description' => 'Free On Board',
                'description' => 'The seller delivers the goods on board the vessel nominated by the buyer at the named port of shipment or procures the goods already so delivered.
The buyer becomes responsible for bearing all costs and risks from the moment the goods are on board the vessel, so the buyer will pay for the International transportation, insurance, and any further costs.
Seller’s costs include delivering the goods to the port of shipment, loading costs onto the vessel, and export duties, taxes, and customs clearance.
Buyer covers costs including main carriage (freight) costs from the port of loading to the port of destination, unloading costs at the destination port, and import duties, taxes, and customs clearance at the destination country.'
            ),

            array(
                'shortcut' => 'CFR',
                'short_description' => 'Cost and Freight',
                'description' => 'The seller delivers the goods on board the vessel or procures the goods already so delivered.
The risk of loss of or damage to the goods passes when the products are on board the vessel.
The seller must contract for and pay the costs and freight necessary to bring the goods to the named port of destination.'
            ),

            array(
                'shortcut' => 'CIF',
                'short_description' => 'Cost, Insurance and Freight',
                'description' => 'The seller delivers the goods on board the vessel or procures the goods already so delivered. The risk of loss of or damage to the goods passes when the products are on the ship.
The seller must contract for and pay the costs and freight necessary to bring the goods to the named port of destination.
The seller also contracts for insurance cover against the buyer’s risk of loss of or damage to the goods during the carriage.
The buyer should note that under CIF the seller is required to obtain insurance only on minimum cover. Should the buyer wish to have more insurance protection, it will need either to agree as much expressly with the seller or to make its own extra insurance arrangements.'
            ),

            array(
                'shortcut' => 'CPT',
                'short_description' => 'Carriage Paid To',
                'description' => 'The seller delivers the goods to the carrier or another person nominated by the seller at an agreed place (if any such site is agreed between parties).
The seller must contract for and pay the costs of carriage necessary to bring the goods to the named place of destination.'
            ),

            array(
                'shortcut' => 'CIP',
                'short_description' => 'Carriage And Insurance Paid To',
                'description' => 'The seller has the same responsibilities as CPT, but they also contract for insurance cover against the buyer’s risk of loss of or damage to the goods during the carriage.
The buyer should note that under CIP the seller is required to obtain insurance only on minimum cover. Should the buyer wish to have more insurance protection, it will need either to agree as much expressly with the seller or to make its own extra insurance arrangements.'
            ),

            array(
                'shortcut' => 'DPU',
                'short_description' => 'Delivered At Place Unloaded (replaces Incoterm® 2010 DAT)',
                'description' => 'DPU is a new Incoterm® rule that replaces the former Incoterm® DAT (Delivered At Terminal).
The seller delivers when the goods are unloaded and placed at the disposal of the buyer at a named place of destination.
The seller bears all risks involved in bringing the goods to, and unloading them at the named place of destination.'
            ),

            array(
                'shortcut' => 'DDP',
                'short_description' => 'Delivered Duty Paid',
                'description' => 'The seller delivers the goods when the goods are placed at the disposal of the buyer, cleared for import on the arriving means of transport ready for unloading at the named place of destination.
The seller bears all the costs and risks involved in bringing the goods to the place of destination. They must clear the products not only for export but also for import, to pay any duty for both export and import and to carry out all customs formalities.
Under DDP, the seller pays for all shipping costs, including import customs clearance, import duties & taxes, and any additional charges involved in delivering the goods to the named place of destination.'
            ),




        );

        DB::table('incoterms')->insert($incoterms);
    }
}
