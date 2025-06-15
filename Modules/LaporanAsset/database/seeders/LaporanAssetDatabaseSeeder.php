<?php

namespace Modules\LaporanAsset\database\seeders;
//use Modules\LaporanAsset\database\seeders\LaporanAssetDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\LaporanAsset\Models\LaporanAsset;
use Carbon\Carbon;
class LaporanAssetDatabaseSeeder extends Seeder
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
         * LaporanAssets Seed
         * ------------------
         */

        // DB::table('laporanassets')->truncate();
        // echo "Truncate: laporanassets \n";

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
        //         $data = LaporanAsset::create($row);

        //     }


        LaporanAsset::factory()->count(20)->create();
        $rows = LaporanAsset::all();
        echo " Insert: laporanassets \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
