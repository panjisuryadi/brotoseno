<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

    $produk = [
            [
                'category_code'                  => 'C-00001',
                'category_name'                  => 'Mutiara',
                'kategori_produk_id'             => 3,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00002',
                'category_name'                  => 'Berlian',
                'kategori_produk_id'             => 2,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00003',
                'category_name'                  => 'SIlver / Perak',
                'kategori_produk_id'             => 3,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00004',
                'category_name'                  => 'Logam Mulia',
                'kategori_produk_id'             => 1,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00005',
                'category_name'                  => 'Paladium / Rhodium / Osmium / Iridium',
                'kategori_produk_id'             => 3,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00006',
                'category_name'                  => 'Emas Rosegold',
                'kategori_produk_id'             => 1,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00007',
                'category_name'                  => 'Emas Putih',
                'kategori_produk_id'             => 1,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00008',
                'category_name'                  => 'Emas Kuning',
                'kategori_produk_id'             => 1,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],

        ];

        foreach ($produk as $pdata) {
            $produk = Category::create($pdata);

          }

    }








}


