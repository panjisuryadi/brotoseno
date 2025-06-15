<?php

namespace Modules\KategoriMutiara\database\seeders;
//use Modules\KategoriMutiara\database\seeders\KategoriMutiaraDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KategoriMutiara\Models\KategoriMutiara;
use Carbon\Carbon;
class KategoriMutiaraDatabaseSeeder extends Seeder
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
         * KategoriMutiaras Seed
         * ------------------
         */

        // DB::table('kategorimutiaras')->truncate();
        // echo "Truncate: kategorimutiaras \n";

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
        //         $data = KategoriMutiara::create($row);

        //     }


        KategoriMutiara::factory()->count(20)->create();
        $rows = KategoriMutiara::all();
        echo " Insert: kategorimutiaras \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
