<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SeedKategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
      // Schema::disableForeignKeyConstraints();

        $faker = \Faker\Factory::create('id_ID');
        $produk = [
            [
                'category_code'                  => 'C-00001',
                'category_name'                  => 'Mutiara',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00002',
                'category_name'                  => 'Berlian',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00003',
                'category_name'                  => 'SIlver / Perak',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00004',
                'category_name'                  => 'Logam Mulia',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00005',
                'category_name'                  => 'Paladium / Rhodium / Osmium / Iridium',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00006',
                'category_name'                  => 'Emas Rosegold',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00007',
                'category_name'                  => 'Emas Putih',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00008',
                'category_name'                  => 'Emas Kuning',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],

        ];

        foreach ($produk as $pdata) {
            $produk = Category::create($pdata);

          }
}
