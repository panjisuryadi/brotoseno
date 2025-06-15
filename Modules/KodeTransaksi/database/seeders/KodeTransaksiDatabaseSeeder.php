<?php

namespace Modules\KodeTransaksi\database\seeders;
//use Modules\KodeTransaksi\database\seeders\KodeTransaksiDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KodeTransaksi\Models\KodeTransaksi;
use Carbon\Carbon;
class KodeTransaksiDatabaseSeeder extends Seeder
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
         * KodeTransaksis Seed
         * ------------------
         */

        // DB::table('kodetransaksis')->truncate();
        // echo "Truncate: kodetransaksis \n";

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
        //         $data = KodeTransaksi::create($row);

        //     }


        KodeTransaksi::factory()->count(20)->create();
        $rows = KodeTransaksi::all();
        echo " Insert: kodetransaksis \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
