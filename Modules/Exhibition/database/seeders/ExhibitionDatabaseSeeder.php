<?php

namespace Modules\Exhibition\database\seeders;
//use Modules\Exhibition\database\seeders\ExhibitionDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Exhibition\Models\Exhibition;
use Carbon\Carbon;
class ExhibitionDatabaseSeeder extends Seeder
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
         * Exhibitions Seed
         * ------------------
         */

        // DB::table('exhibitions')->truncate();
        // echo "Truncate: exhibitions \n";

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
        //         $data = Exhibition::create($row);

        //     }


        Exhibition::factory()->count(20)->create();
        $rows = Exhibition::all();
        echo " Insert: exhibitions \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
