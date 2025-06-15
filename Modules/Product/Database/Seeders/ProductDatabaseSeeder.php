<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class ProductDatabaseSeeder extends Seeder
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
                'product_code'                  => 'P-00001',
                'product_name'                  => 'Cincin Emas',
                'category_id'                   =>  1,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  1000000,
                'product_quantity'                 =>  100,
                'product_price'                 =>  1000000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'product_code'                  => 'P-00002',
                'product_name'                  => 'Gelang Emas',
                'category_id'                   =>  2,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  1200000,
                'product_quantity'                 =>  100,
                'product_price'                 =>  1200000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'product_code'                  => 'P-00003',
                'product_name'                  => 'Kalung Emas',
                'category_id'                   =>  1,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  130000,
                'product_quantity'                 =>  5,
                'product_price'                 =>  130000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'product_code'                  => 'P-00004',
                'product_name'                  => 'Liontin',
                'category_id'                   =>  1,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  130000,
                'product_quantity'                 =>  5,
                'product_price'                 =>  130000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],
           [
                'product_code'                  => 'P-00005',
                'product_name'                  => 'Cincin Berlian v4',
                'category_id'                   =>  1,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  110000,
                'product_quantity'                 =>  5,
                'product_price'                 =>  110000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'product_code'                  => 'P-00006',
                'product_name'                  => 'Kalung Emas Putih',
                'category_id'                   =>  2,
                'product_barcode_symbology'     =>  'C128',
                'product_cost'                  =>  110000,
                'product_quantity'                 =>  5,
                'product_price'                 =>  110000,
                'product_stock_alert'                 =>  5,
                'product_unit'                  =>  'Gram',
                'product_order_tax'             =>  null,
                'product_tax_type'              =>  null,
                'product_note'                  =>  null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],

        ];

        foreach ($produk as $pdata) {
            $produk = Product::create($pdata);

          }


      }
}


