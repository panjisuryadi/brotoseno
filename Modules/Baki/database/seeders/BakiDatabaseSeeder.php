<?php

namespace Modules\Baki\database\seeders;
//use Modules\Baki\database\seeders\BakiDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Baki\Models\Baki;
use Carbon\Carbon;
class BakiDatabaseSeeder extends Seeder
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
         * Bakis Seed
         * ------------------
         */

        // DB::table('bakis')->truncate();
        // echo "Truncate: bakis \n";

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
        //         $data = Baki::create($row);

        //     }


        Baki::factory()->count(20)->create();
        $rows = Baki::all();
        echo " Insert: bakis \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
