<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => 1,
            // 'customer_id' => null, // We'll handle this in the seeder to make it autoincrement
            // 'place_id' => $this->faker->numberBetween(1, 24),
            // 'is_customer' => 1,
            // 'name' => $this->faker->company,
            // 'address' => $this->faker->address,
            // 'tax_number' => $this->faker->unique()->numerify('MK########'),
            // 'reg_number' => $this->faker->unique()->numerify('#####'),
            // 'web' => $this->faker->url,
        ];
    }
}
