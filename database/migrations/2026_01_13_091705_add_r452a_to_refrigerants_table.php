<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('refrigerants', function (Blueprint $table) {
            DB::table('refrigerants')->insert([
                'short_name' => 'R452A',
                'synonym' => 'Blend of R32 / R125 / R1234yf',
                'formula' => 'R32 (11%) / R125 (59%) / R1234yf (30%)',
                'gwp' => 2140,
                'boiling_point' => '-46.1°C (-51.0°F)',
                'freezing_point' => 'Not defined (zeotropic blend)',
                'flammability' => 'Mildly flammable (ASHRAE A2L)',
                'oxidizing' => 'Not oxidizing; stable under normal conditions',
                'vapour_pressure' => 'at 25°C ≈ 1180 kPa',
                'relative_density' => 'at 25°C ≈ 1040 kg/m³ (liquid)',
                'evaporating_temp' => 'Typical range: -45°C to +10°C',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refrigerants', function (Blueprint $table) {
            DB::table('refrigerants')
                ->where('short_name', 'R452A')
                ->delete();
        });
    }
};
