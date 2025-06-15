<?php

namespace Modules\LogActivity\database\seeders;
//use Modules\LogActivity\database\seeders\LogActivityDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\LogActivity\Models\LogActivity;
use Carbon\Carbon;
class LogActivityDatabaseSeeder extends Seeder
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
         * LogActivities Seed
         * ------------------
         */

        // DB::table('logactivities')->truncate();
        // echo "Truncate: logactivities \n";

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
        //         $data = LogActivity::create($row);

        //     }


        LogActivity::factory()->count(20)->create();
        $rows = LogActivity::all();
        echo " Insert: logactivities \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
