<?php

namespace Modules\Gudang\database\seeders;
//use Modules\Gudang\database\seeders\GudangDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Gudang\Models\Gudang;
use Carbon\Carbon;
class GudangDatabaseSeeder extends Seeder
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
         * Gudangs Seed
         * ------------------
         */

        // DB::table('gudangs')->truncate();
        // echo "Truncate: gudangs \n";

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
        //         $data = Gudang::create($row);

        //     }


        Gudang::factory()->count(20)->create();
        $rows = Gudang::all();
        echo " Insert: gudangs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
