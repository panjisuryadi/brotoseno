<?php

namespace Modules\PenjualanSale\database\seeders;
//use Modules\PenjualanSale\database\seeders\PenjualanSaleDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PenjualanSale\Models\PenjualanSale;
use Carbon\Carbon;
class PenjualanSaleDatabaseSeeder extends Seeder
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
         * PenjualanSales Seed
         * ------------------
         */

        // DB::table('penjualansales')->truncate();
        // echo "Truncate: penjualansales \n";

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
        //         $data = PenjualanSale::create($row);

        //     }


        PenjualanSale::factory()->count(20)->create();
        $rows = PenjualanSale::all();
        echo " Insert: penjualansales \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
