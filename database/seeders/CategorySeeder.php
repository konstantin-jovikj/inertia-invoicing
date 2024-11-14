<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::truncate();

        $categories = [
            ['name' => 'Неутрални Елементи'],
            ['name' => 'Разладни Елементи'],
            ['name' => 'Електрични Топли Елементи'],
            ['name' => 'Плински Топли Елементи'],
            ['name' => 'Електрични Машини/Апарати'],
        ];

        // Insert each manufacturer
        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}
