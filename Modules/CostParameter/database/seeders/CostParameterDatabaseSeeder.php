<?php

namespace Modules\CostParameter\database\seeders;
//use Modules\CostParameter\database\seeders\CostParameterDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CostParameter\Models\CostParameter;
use Carbon\Carbon;
class CostParameterDatabaseSeeder extends Seeder
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
         * CostParameters Seed
         * ------------------
         */

        // DB::table('costparameters')->truncate();
        // echo "Truncate: costparameters \n";

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
        //         $data = CostParameter::create($row);

        //     }


        CostParameter::factory()->count(20)->create();
        $rows = CostParameter::all();
        echo " Insert: costparameters \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
