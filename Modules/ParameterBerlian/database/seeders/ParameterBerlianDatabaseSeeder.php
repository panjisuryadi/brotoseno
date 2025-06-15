<?php

namespace Modules\ParameterBerlian\database\seeders;
//use Modules\ParameterBerlian\database\seeders\ParameterBerlianDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ParameterBerlian\Models\ParameterBerlian;
use Carbon\Carbon;
class ParameterBerlianDatabaseSeeder extends Seeder
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
         * ParameterBerlians Seed
         * ------------------
         */

        // DB::table('parameterberlians')->truncate();
        // echo "Truncate: parameterberlians \n";

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
        //         $data = ParameterBerlian::create($row);

        //     }


        ParameterBerlian::factory()->count(20)->create();
        $rows = ParameterBerlian::all();
        echo " Insert: parameterberlians \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
