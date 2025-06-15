<?php

namespace Modules\PenentuanHarga\database\seeders;
//use Modules\PenentuanHarga\database\seeders\PenentuanHargaDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PenentuanHarga\Models\PenentuanHarga;
use Carbon\Carbon;
class PenentuanHargaDatabaseSeeder extends Seeder
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
         * PenentuanHargas Seed
         * ------------------
         */

        // DB::table('penentuanhargas')->truncate();
        // echo "Truncate: penentuanhargas \n";

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
        //         $data = PenentuanHarga::create($row);

        //     }


        PenentuanHarga::factory()->count(20)->create();
        $rows = PenentuanHarga::all();
        echo " Insert: penentuanhargas \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
