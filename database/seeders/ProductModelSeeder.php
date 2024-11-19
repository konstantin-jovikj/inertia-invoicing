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
        ['category_id' => 1, 'model' => 'Неутрални Елементи', 'model_en' => 'Neutral Elements'],
        ['category_id' => 2, 'model' => 'Разладни Маси за одржување', 'model_en' => 'Refrigerated Counters for normal temperature'],
        ['category_id' => 2, 'model' => 'Разладни Витрини за одржување', 'model_en' => 'Refrigerated Display Cases for normal temperature'],
        ['category_id' => 2, 'model' => 'Фрижидери за одржување', 'model_en' => 'Refrigerators for normal temperature'],
        ['category_id' => 2, 'model' => 'Замрзнувачи', 'model_en' => 'Freezers'],
        ['category_id' => 3, 'model' => 'Електрични Скари', 'model_en' => 'Electric Grills'],
        ['category_id' => 3, 'model' => 'Електрични Шпорети/Решо', 'model_en' => 'Electric Stoves'],
        ['category_id' => 3, 'model' => 'Електрични Фритези', 'model_en' => 'Electric Fryers'],
        ['category_id' => 5, 'model' => 'Електрични Миксери', 'model_en' => 'Electric Mixers'],
        ['category_id' => 3, 'model' => 'Електрични Рерни/Печки', 'model_en' => 'Electric Ovens'],
        ['category_id' => 3, 'model' => 'Електрични Казани', 'model_en' => 'Electric Kettles'],
        ['category_id' => 3, 'model' => 'Електрични Кипери', 'model_en' => 'Electric Tilting Pans'],
        ['category_id' => 3, 'model' => 'Електрични Тостери', 'model_en' => 'Electric Toasters'],
        ['category_id' => 4, 'model' => 'Плински Скари', 'model_en' => 'Gas Grills'],
        ['category_id' => 4, 'model' => 'Плински Шпорети/Решо', 'model_en' => 'Gas Stoves'],
        ['category_id' => 4, 'model' => 'Плински Фритези', 'model_en' => 'Gas Fryers'],
        ['category_id' => 4, 'model' => 'Плински Рерни/Печки', 'model_en' => 'Gas Ovens'],
        ['category_id' => 4, 'model' => 'Плински Казани', 'model_en' => 'Gas Kettles'],
        ['category_id' => 4, 'model' => 'Плински Кипери', 'model_en' => 'Gas Tilting Pans'],
        ['category_id' => 4, 'model' => 'Плински Тостери', 'model_en' => 'Gas Toasters'],
    ];

    // Insert each manufacturer
    foreach ($models as $data) {
        ProductModel::create($data);
    }
}

}
