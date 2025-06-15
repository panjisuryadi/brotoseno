<?php

namespace Modules\ParameterKadar\database\seeders;
//use Modules\ParameterKadar\database\seeders\ParameterKadarDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ParameterKadar\Models\ParameterKadar;
use Carbon\Carbon;
class ParameterKadarDatabaseSeeder extends Seeder
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
         * ParameterKadars Seed
         * ------------------
         */

        // DB::table('parameterkadars')->truncate();
        // echo "Truncate: parameterkadars \n";

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
        //         $data = ParameterKadar::create($row);

        //     }


        ParameterKadar::factory()->count(20)->create();
        $rows = ParameterKadar::all();
        echo " Insert: parameterkadars \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
