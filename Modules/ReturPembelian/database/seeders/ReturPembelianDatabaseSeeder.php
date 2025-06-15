<?php

namespace Modules\ReturPembelian\database\seeders;
//use Modules\ReturPembelian\database\seeders\ReturPembelianDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ReturPembelian\Models\ReturPembelian;
use Carbon\Carbon;
class ReturPembelianDatabaseSeeder extends Seeder
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
         * ReturPembelians Seed
         * ------------------
         */

        // DB::table('returpembelians')->truncate();
        // echo "Truncate: returpembelians \n";

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
        //         $data = ReturPembelian::create($row);

        //     }


        ReturPembelian::factory()->count(20)->create();
        $rows = ReturPembelian::all();
        echo " Insert: returpembelians \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
