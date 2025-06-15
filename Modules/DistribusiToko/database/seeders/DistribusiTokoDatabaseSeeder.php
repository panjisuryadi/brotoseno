<?php

namespace Modules\DistribusiToko\database\seeders;
//use Modules\DistribusiToko\database\seeders\DistribusiTokoDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\DistribusiToko\Models\DistribusiToko;
use Carbon\Carbon;
class DistribusiTokoDatabaseSeeder extends Seeder
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
         * DistribusiTokos Seed
         * ------------------
         */

        // DB::table('distribusitokos')->truncate();
        // echo "Truncate: distribusitokos \n";

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
        //         $data = DistribusiToko::create($row);

        //     }


        DistribusiToko::factory()->count(20)->create();
        $rows = DistribusiToko::all();
        echo " Insert: distribusitokos \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
