<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class KategoriDatabaseSeeder extends Seeder
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
                'category_name'                  => 'Minuman',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00002',
                'category_name'                  => 'Makanan',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00003',
                'category_name'                  => 'Elekronik',
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],

        ];

        foreach ($produk as $pdata) {
            $produk = Category::create($pdata);

          }
}


