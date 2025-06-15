<?php

namespace Modules\CustomerSales\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CustomerSales\Entities\CustomerSales;

class CustomerSalesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerSales::factory()->count(5)->create();
    }
}
