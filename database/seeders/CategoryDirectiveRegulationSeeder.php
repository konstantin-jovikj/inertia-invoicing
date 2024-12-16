<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryDirectiveRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define relationships for each category
        $relationships = [
            [
                'category_id' => 1,
                'regulations' => [1, 8],
                'directives' => [1, 6, 12],
            ],
            [
                'category_id' => 2,
                'regulations' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                'directives' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13],
            ],
            [
                'category_id' => 3,
                'regulations' => [1, 2, 3, 4, 5, 7, 8, 11, 12, 13],
                'directives' => [1, 2, 3, 4, 6, 7, 8, 9, 10, 12],
            ],
            [
                'category_id' => 4,
                'regulations' => [1, 8],
                'directives' => [1, 3, 5, 6, 11, 12],
            ],
            [
                'category_id' => 5,
                'regulations' => [1, 2, 3, 4, 5, 8, 11, 12, 13],
                'directives' => [1, 2, 3, 4, 6, 7, 8, 9, 10],
            ],
            [
                'category_id' => 6,
                'regulations' => [1, 14],
                'directives' => [1, 6],
            ],
            [
                'category_id' => 7,
                'regulations' => [1, 2, 3, 4, 7, 8, 12, 13, 15],
                'directives' => [1, 4, 6, 7, 8, 9, 10],
            ],
            // Add more categories here if needed
        ];

        foreach ($relationships as $relation) {
            $categoryId = $relation['category_id'];

            // Insert regulation relationships
            foreach ($relation['regulations'] as $regulationId) {
                DB::table('category_directive_regulation')->insert([
                    'category_id' => $categoryId,
                    'regulation_id' => $regulationId,
                    'directive_id' => null, // No directive in this case
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert directive relationships
            foreach ($relation['directives'] as $directiveId) {
                DB::table('category_directive_regulation')->insert([
                    'category_id' => $categoryId,
                    'regulation_id' => null, // No regulation in this case
                    'directive_id' => $directiveId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
