<?php

namespace Modules\JenisMutiara\database\seeders;
//use Modules\JenisMutiara\database\seeders\JenisMutiaraDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisMutiara\Models\JenisMutiara;
use Carbon\Carbon;
class JenisMutiaraDatabaseSeeder extends Seeder
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
         * JenisMutiaras Seed
         * ------------------
         */

        // DB::table('jenismutiaras')->truncate();
        // echo "Truncate: jenismutiaras \n";

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
        //         $data = JenisMutiara::create($row);

        //     }


        JenisMutiara::factory()->count(20)->create();
        $rows = JenisMutiara::all();
        echo " Insert: jenismutiaras \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
