<?php

namespace Modules\GoldParameter\database\seeders;
//use Modules\GoldParameter\database\seeders\GoldParameterDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\GoldParameter\Models\GoldParameter;
use Carbon\Carbon;
class GoldParameterDatabaseSeeder extends Seeder
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
         * GoldParameters Seed
         * ------------------
         */

        // DB::table('goldparameters')->truncate();
        // echo "Truncate: goldparameters \n";

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
        //         $data = GoldParameter::create($row);

        //     }


        GoldParameter::factory()->count(20)->create();
        $rows = GoldParameter::all();
        echo " Insert: goldparameters \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
