<?php

namespace Modules\StokCabang\database\seeders;
//use Modules\StokCabang\database\seeders\StokCabangDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\StokCabang\Models\StokCabang;
use Carbon\Carbon;
class StokCabangDatabaseSeeder extends Seeder
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
         * StokCabangs Seed
         * ------------------
         */

        // DB::table('stokcabangs')->truncate();
        // echo "Truncate: stokcabangs \n";

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
        //         $data = StokCabang::create($row);

        //     }


        StokCabang::factory()->count(20)->create();
        $rows = StokCabang::all();
        echo " Insert: stokcabangs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
