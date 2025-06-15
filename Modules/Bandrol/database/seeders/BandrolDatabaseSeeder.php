<?php

namespace Modules\Bandrol\database\seeders;
//use Modules\Bandrol\database\seeders\BandrolDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Bandrol\Models\Bandrol;
use Carbon\Carbon;
class BandrolDatabaseSeeder extends Seeder
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
         * Bandrols Seed
         * ------------------
         */

        // DB::table('bandrols')->truncate();
        // echo "Truncate: bandrols \n";

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
        //         $data = Bandrol::create($row);

        //     }


        Bandrol::factory()->count(20)->create();
        $rows = Bandrol::all();
        echo " Insert: bandrols \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
