<?php

namespace Modules\Produksi\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Produksi\Models\Satuans;

class SatuanSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Gram',
                'code' => 'gr',
            ],
            [
                'name' => 'Carat',
                'code' => 'ct',
            ],
            [
                'name' => 'Pcs',
                'code' => 'pcs',
            ],
        ];

        Satuans::insert($data);
    }
}
