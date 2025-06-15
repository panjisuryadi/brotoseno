<?php

namespace Modules\PenerimaanBarangLuar\database\seeders;
//use Modules\PenerimaanBarangLuar\database\seeders\PenerimaanBarangLuarDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;
use Carbon\Carbon;
class PenerimaanBarangLuarDatabaseSeeder extends Seeder
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
         * PenerimaanBarangLuars Seed
         * ------------------
         */

        // DB::table('penerimaanbarangluars')->truncate();
        // echo "Truncate: penerimaanbarangluars \n";

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
        //         $data = PenerimaanBarangLuar::create($row);

        //     }


        PenerimaanBarangLuar::factory()->count(20)->create();
        $rows = PenerimaanBarangLuar::all();
        echo " Insert: penerimaanbarangluars \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
