<?php

namespace Modules\Produksi\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\ProductStatus;

class AddStatusDraftDistProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::create([
            'id' => 12,
            'name' => 'dalam perjalanan'
        ]);
    }
}
