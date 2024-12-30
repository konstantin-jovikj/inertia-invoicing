<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $models = [
        ['category_id' => 1, 'model' => 'NEUTRAL ELEMENT', 'description' => 'Neutral Element'],
        ['category_id' => 1, 'model' => 'NEUTRAL TABLE', 'description' => 'Neutral Table'],
        ['category_id' => 1, 'model' => 'NEUTRAL BAR', 'description' => 'Neutral Bar'],
        ['category_id' => 1, 'model' => 'NEUTRAL PAN/TRAY', 'description' => 'Neutral Pan/Tray'],
        ['category_id' => 2, 'model' => 'FRIGO BENCH', 'description' => 'Refrigerated Counter for normal temperature'],
        ['category_id' => 2, 'model' => 'CUBICA', 'description' => 'Refrigerated Display Case for normal temperature'],
        ['category_id' => 2, 'model' => 'FRIGO PASTRY', 'description' => 'Refrigerated Display Case for pastry for normal temperature'],
        ['category_id' => 2, 'model' => 'FRIGO GELATO', 'description' => 'Ice-Cream Freezer'],
        ['category_id' => 2, 'model' => 'FRIGO FREEZE', 'description' => 'Freezer'],
        ['category_id' => 3, 'model' => 'FRIGO GRILL', 'description' => 'Electric Grill'],
        ['category_id' => 3, 'model' => 'FRIGO STOVE', 'description' => 'Electric Stove'],
        ['category_id' => 3, 'model' => 'FRIGO FRYER', 'description' => 'Electric Fryer'],
        ['category_id' => 3, 'model' => 'FRIGO PASTA', 'description' => 'Electric Fryer'],
        ['category_id' => 3, 'model' => 'FRIGO HOT', 'description' => 'Electric Hot table'],
        ['category_id' => 3, 'model' => 'FRIGO IR WARMER', 'description' => 'Electric IR Food Warmer'],
        ['category_id' => 5, 'model' => 'FRIGO MIXER', 'description' => 'Electric Mixer'],
        ['category_id' => 7, 'model' => 'FRIGO HOOD', 'description' => 'Stainless Steel Hood'],
        ['category_id' => 3, 'model' => 'FRIGO OVEN', 'description' => 'Electric Oven'],
        ['category_id' => 3, 'model' => 'FRIGO KETTLE', 'description' => 'Electric Kettle'],
        ['category_id' => 3, 'model' => 'FRIGO TILTING PAN', 'description' => 'Electric Tilting Pan'],
        ['category_id' => 3, 'model' => 'FRIGO TOASTER', 'description' => 'Electric Toaster'],
        ['category_id' => 4, 'model' => 'FRIGO GAS GRILL', 'description' => 'Gas Grill'],
        ['category_id' => 4, 'model' => 'FRIGO GAS STOVE', 'description' => 'Gas Stove'],
        ['category_id' => 4, 'model' => 'FRIGO GAS FRYER', 'description' => 'Gas Fryer'],
        ['category_id' => 4, 'model' => 'FRIGO GAS OVEN', 'description' => 'Gas Oven'],
        ['category_id' => 4, 'model' => 'FRIGO GAS KETTLE', 'description' => 'Gas Kettle'],
        ['category_id' => 4, 'model' => 'FRIGO TILTING PAN', 'description' => 'Gas Tilting Pan'],
        ['category_id' => 4, 'model' => 'FRIGO TOASTER', 'description' => 'Gas Toaster'],
        ['category_id' => 6, 'model' => 'FRIGO BARBEQUE', 'description' => 'Characoal Grill'],

    ];

    // Insert each manufacturer
    foreach ($models as $data) {
        ProductModel::create($data);
    }
}

}
