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
            ['name' => 'Разладни Маси'],
            ['name' => 'Разладни Витрини'],
            ['name' => 'Електрични Скари'],
            ['name' => 'Електрични Шпорети/Решо'],
            ['name' => 'Електрични Фритези'],
            ['name' => 'Електрични Миксери'],
            ['name' => 'Електрични Рерни/Печки'],
            ['name' => 'Електрични Казани'],
            ['name' => 'Електрични Кипери'],
            ['name' => 'Електрични Тостери'],
            ['name' => 'Плински Скари'],
            ['name' => 'Плински Шпорети/Решо'],
            ['name' => 'Плински Фритези'],
            ['name' => 'Плински Рерни/Печки'],
            ['name' => 'Плински Казани'],
            ['name' => 'Плински Кипери'],
            ['name' => 'Плински Тостери'],
        ];

        // Insert each manufacturer
        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}
