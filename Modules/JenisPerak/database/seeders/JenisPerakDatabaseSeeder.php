<?php

namespace Modules\JenisPerak\database\seeders;
//use Modules\JenisPerak\database\seeders\JenisPerakDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisPerak\Models\JenisPerak;
use Carbon\Carbon;
class JenisPerakDatabaseSeeder extends Seeder
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
         * JenisPeraks Seed
         * ------------------
         */

        // DB::table('jenisperaks')->truncate();
        // echo "Truncate: jenisperaks \n";

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
        //         $data = JenisPerak::create($row);

        //     }


        JenisPerak::factory()->count(20)->create();
        $rows = JenisPerak::all();
        echo " Insert: jenisperaks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
