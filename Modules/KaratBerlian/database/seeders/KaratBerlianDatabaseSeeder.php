<?php

namespace Modules\KaratBerlian\database\seeders;
//use Modules\KaratBerlian\database\seeders\KaratBerlianDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KaratBerlian\Models\KaratBerlian;
use Carbon\Carbon;
class KaratBerlianDatabaseSeeder extends Seeder
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
         * KaratBerlians Seed
         * ------------------
         */

        // DB::table('karatberlians')->truncate();
        // echo "Truncate: karatberlians \n";

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
        //         $data = KaratBerlian::create($row);

        //     }


        KaratBerlian::factory()->count(20)->create();
        $rows = KaratBerlian::all();
        echo " Insert: karatberlians \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
