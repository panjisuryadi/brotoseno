<?php

namespace Modules\KategoriProduk\database\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KategoriProduk\Models\KategoriProduk;
use Carbon\Carbon;
class KategoriProdukDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * KategoriProduks Seed
         * ------------------
         */

       // DB::table('kategoriproduks')->truncate();
       // echo "Truncate: kategoriproduks \n";

         $data = [
            [
                'id'                 => 1,
                'name'               => 'Gold',
                'description'        => 'Gold - Produk',
                'image'              => 'no_foto.png',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],
           [
                'id'                 => 2,
                'name'               => 'Diamond',
                'description'        => 'Diamond - Produk',
                'image'              => 'no_foto.png',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ], [
                'id'                 => 3,
                'name'               => 'Pearl',
                'description'        => 'Mutiara - Produk',
                'image'              => 'no_foto.png',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],

        ];

            foreach ($data as $row) {
                $data = KategoriProduk::create($row);

            }


        //KategoriProduk::factory()->count(20)->create();
        //$rows = KategoriProduk::all();
        echo " Insert: kategoriproduks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
