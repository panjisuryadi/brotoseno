<?php

namespace Modules\Produksi\database\seeders;
//use Modules\Produksi\database\seeders\ProduksiDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Produksi\Models\Produksi;
use Carbon\Carbon;
class ProduksiDatabaseSeeder extends Seeder
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
         * Produksis Seed
         * ------------------
         */

        // DB::table('produksis')->truncate();
        // echo "Truncate: produksis \n";

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
        //         $data = Produksi::create($row);

        //     }


        Produksi::factory()->count(20)->create();
        $rows = Produksi::all();
        echo " Insert: produksis \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
