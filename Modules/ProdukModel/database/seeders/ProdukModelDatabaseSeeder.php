<?php

namespace Modules\ProdukModel\database\seeders;
//use Modules\ProdukModel\database\seeders\ProdukModelDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ProdukModel\Models\ProdukModel;
use Carbon\Carbon;
class ProdukModelDatabaseSeeder extends Seeder
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
         * ProdukModels Seed
         * ------------------
         */

        // DB::table('produkmodels')->truncate();
        // echo "Truncate: produkmodels \n";

        //  $data = [
        //     [
        //         'id'                 => 1,
        //         'name'               => 'Inclusive',
        //         'description'        => 'Diamond - Inclusive',
        //         'created_at'         => Carbon::now(),
        //         'updated_at'         => Carbon::now(),
        //     ],

        // ];

        //     foreach ($data as $row) {
        //         $data = ProdukModel::create($row);

        //     }


        ProdukModel::factory()->count(20)->create();
        $rows = ProdukModel::all();
        echo " Insert: produkmodels \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
