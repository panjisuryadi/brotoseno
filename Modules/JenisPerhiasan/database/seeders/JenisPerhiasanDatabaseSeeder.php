<?php

namespace Modules\JenisPerhiasan\database\seeders;
//use Modules\JenisPerhiasan\database\seeders\JenisPerhiasanDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisPerhiasan\Models\JenisPerhiasan;
use Carbon\Carbon;
class JenisPerhiasanDatabaseSeeder extends Seeder
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
         * JenisPerhiasans Seed
         * ------------------
         */

        // DB::table('jenisperhiasans')->truncate();
        // echo "Truncate: jenisperhiasans \n";

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
        //         $data = JenisPerhiasan::create($row);

        //     }


        JenisPerhiasan::factory()->count(20)->create();
        $rows = JenisPerhiasan::all();
        echo " Insert: jenisperhiasans \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
