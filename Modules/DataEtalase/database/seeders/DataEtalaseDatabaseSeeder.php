<?php

namespace Modules\DataEtalase\database\seeders;
//use Modules\DataEtalase\database\seeders\DataEtalaseDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DataEtalase\Models\DataEtalase;
use Carbon\Carbon;
class DataEtalaseDatabaseSeeder extends Seeder
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
         * DataEtalases Seed
         * ------------------
         */

        // DB::table('dataetalases')->truncate();
        // echo "Truncate: dataetalases \n";

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
        //         $data = DataEtalase::create($row);

        //     }


        DataEtalase::factory()->count(20)->create();
        $rows = DataEtalase::all();
        echo " Insert: dataetalases \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
