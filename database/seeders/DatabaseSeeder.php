<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BankSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            CountrySeeder::class,
            PlaceSeeder::class,
            CustomerTypeSeeder::class,
            BankSeeder::class,
            DocumentTypeSeeder::class,
            IncotermSeeder::class,
            TaxSeeder::class,
            CurencySeeder::class,
            DriverSeeder::class,
            VehicleSeeder::class,
            NoteTypeSeeder::class,
            DeclarationSeeder::class,
            TermsSeeder::class,
            ManufacturerSeeder::class,
            RefrigerantSeeder::class,
            RegulationSeeder::class,
            CategorySeeder::class,
            TemperatureSeeder::class,
            VoltageSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            CompanySeeder::class,
            ProductModelSeeder::class,



        ]);
    }
}
