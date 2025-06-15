<?php

namespace Modules\PenerimaanBarangDP\database\seeders;
//use Modules\PenerimaanBarangDP\database\seeders\PenerimaanBarangDPDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PenerimaanBarangDP\Models\PenerimaanBarangDP;
use Carbon\Carbon;
class PenerimaanBarangDPDatabaseSeeder extends Seeder
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
         * PenerimaanBarangDPs Seed
         * ------------------
         */

        // DB::table('penerimaanbarangdps')->truncate();
        // echo "Truncate: penerimaanbarangdps \n";

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
        //         $data = PenerimaanBarangDP::create($row);

        //     }


        PenerimaanBarangDP::factory()->count(20)->create();
        $rows = PenerimaanBarangDP::all();
        echo " Insert: penerimaanbarangdps \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
