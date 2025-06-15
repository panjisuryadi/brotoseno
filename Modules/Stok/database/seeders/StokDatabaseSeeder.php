<?php

namespace Modules\Stok\database\seeders;
//use Modules\Stok\database\seeders\StokDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Stok\Models\Stok;
use Carbon\Carbon;
class StokDatabaseSeeder extends Seeder
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
         * Stoks Seed
         * ------------------
         */

        // DB::table('stoks')->truncate();
        // echo "Truncate: stoks \n";

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
        //         $data = Stok::create($row);

        //     }


        Stok::factory()->count(20)->create();
        $rows = Stok::all();
        echo " Insert: stoks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
