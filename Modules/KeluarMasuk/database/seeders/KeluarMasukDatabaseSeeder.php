<?php

namespace Modules\KeluarMasuk\database\seeders;
//use Modules\KeluarMasuk\database\seeders\KeluarMasukDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KeluarMasuk\Models\KeluarMasuk;
use Carbon\Carbon;
class KeluarMasukDatabaseSeeder extends Seeder
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
         * KeluarMasuks Seed
         * ------------------
         */

        // DB::table('keluarmasuks')->truncate();
        // echo "Truncate: keluarmasuks \n";

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
        //         $data = KeluarMasuk::create($row);

        //     }


        KeluarMasuk::factory()->count(20)->create();
        $rows = KeluarMasuk::all();
        echo " Insert: keluarmasuks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
