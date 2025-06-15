<?php

namespace Modules\JenisBuyBack\database\seeders;
//use Modules\JenisBuyBack\database\seeders\JenisBuyBackDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisBuyBack\Models\JenisBuyBack;
use Carbon\Carbon;
class JenisBuyBackDatabaseSeeder extends Seeder
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
         * JenisBuyBacks Seed
         * ------------------
         */

        // DB::table('jenisbuybacks')->truncate();
        // echo "Truncate: jenisbuybacks \n";

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
        //         $data = JenisBuyBack::create($row);

        //     }


        JenisBuyBack::factory()->count(20)->create();
        $rows = JenisBuyBack::all();
        echo " Insert: jenisbuybacks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
