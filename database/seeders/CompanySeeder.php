<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    
        $companies = [
            [
                'name' => 'АГ-Солид Д.О.О.',
                'reg_number' => null,
                'tax_number' => null,
                'logo' => null,
                'cert' => null,
                'user_id' => 1,
                'customer_id' => 2,
                'place_id' => 34, 
                'is_customer' => 1,
                'address' => 'ул: Борис Кидрич 4а/а',
                'web' => '',
                'email' => 'ag-solid@yahoo.com',
                'phone' => '071 822 500',
                'notes' => '',
            ],
            [
                'name' => 'Ангропромет - Тиквешанка',
                'reg_number' => null,
                'tax_number' => null,
                'logo' => null,
                'cert' => null,
                'user_id' => 1,
                'customer_id' => 2,
                'place_id' => 36, 
                'is_customer' => 1,
                'address' => 'ул:Индустриска Бр.15',
                'web' => 'http://www.angro-promet.com/',
                'email' => 'angropromet-tikvesanka@t.mk',
                'phone' => '070 324 787 ',
                'notes' => '',
            ],
            [
                'name' => 'БОКАДО',
                'reg_number' => null,
                'tax_number' => null,
                'logo' => null,
                'cert' => null,
                'user_id' => 1,
                'customer_id' => 2,
                'place_id' => 26, 
                'is_customer' => 1,
                'address' => 'Бул: св.Климент Оџридски 23-1/8',
                'web' => '',
                'email' => 'calovski@bocado.com.mk',
                'phone' => '02 3176 116 / 071 201 118',
                'notes' => '',
            ],
            [
                'name' => 'ВОНД-ДООЕЛ увоз-извоз',
                'reg_number' => null,
                'tax_number' => null,
                'logo' => null,
                'cert' => null,
                'user_id' => 1,
                'customer_id' => 2,
                'place_id' => 26, 
                'is_customer' => 1,
                'address' => 'ул: М.Хаџивасилев -Јасмин бр: 6-3/4',
                'web' => 'vond_mk@yahoo.com',
                'email' => 'calovski@bocado.com.mk',
                'phone' => '02 2784 326 / 070 230 110',
                'notes' => '',
            ],
            [
                'name' => 'Хајбори ',
                'reg_number' => null,
                'tax_number' => null,
                'logo' => null,
                'cert' => null,
                'user_id' => 1,
                'customer_id' => 2,
                'place_id' => 27, 
                'is_customer' => 1,
                'address' => 'ул: М.Хаџивасилев -Јасмин бр: 6-3/4',
                'web' => 'www.haybori.com',
                'email' => 'info@haybori.com',
                'phone' => '070 389 263',
                'notes' => 'fatmir_hb@yahoo.com
gimi_hb@hotmail.com',
            ],
        ];
    
        foreach ($companies as $data) {
            Company::create($data);
        }
    }
    
}
