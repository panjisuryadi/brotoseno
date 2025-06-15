<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewKolomToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


// "product_barcode_symbology" => "C128"
//   "product_stock_alert" => "5"
//   "product_quantity" => "1"
//   "product_unit" => "Gram"
//   "upload" => "on"
//   "image" => null
//   "category_id" => "1"
//   "group_id" => "4"
//   "produk_model" => "1"
//   "cabang_id" => "3"
//   "baki_id" => "3"
//   "supplier_id" => "2"
//   "product_code" => "CBR-CCN-702-09082023"
//   "jenis_mutiara_id" => "2"
//   "kategori_mutiara_id" => "1"
//   "berat_emas" => "0.07"
//   "product_cost" => "Rp 300.000"
//   "margin" => "10"
//   "product_price" => "Rp. 4.000.000"
//   "product_note" => null


 
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
           $table->unsignedBigInteger('jenis_mutiara_id')
           ->nullable()->after('brankas');  

           $table->unsignedBigInteger('produk_model_id')
           ->nullable()->after('jenis_mutiara_id');

           $table->unsignedBigInteger('cabang_id')
           ->nullable()->after('produk_model_id');

            $table->integer('margin')
           ->nullable()->after('cabang_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_items', function (Blueprint $table) {
            

        });
    }
}
