<?php

namespace Modules\Cabang\database\seeders;
//use Modules\Cabang\database\seeders\CabangDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cabang\Models\Cabang;
use Carbon\Carbon;
class CabangDatabaseSeeder extends Seeder
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
         * Cabangs Seed
         * ------------------
         */

        // DB::table('cabangs')->truncate();
        // echo "Truncate: cabangs \n";

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
        //         $data = Cabang::create($row);

        //     }


        Cabang::factory()->count(20)->create();
        $rows = Cabang::all();
        echo " Insert: cabangs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
