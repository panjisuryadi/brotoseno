<?php

namespace Modules\DataRekening\database\seeders;
//use Modules\DataRekening\database\seeders\DataRekeningDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DataRekening\Models\DataRekening;
use Carbon\Carbon;
class DataRekeningDatabaseSeeder extends Seeder
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
         * DataRekenings Seed
         * ------------------
         */

        // DB::table('datarekenings')->truncate();
        // echo "Truncate: datarekenings \n";

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
        //         $data = DataRekening::create($row);

        //     }


        DataRekening::factory()->count(20)->create();
        $rows = DataRekening::all();
        echo " Insert: datarekenings \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
