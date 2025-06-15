<?php

namespace Modules\KondisiPembelian\database\seeders;
//use Modules\KondisiPembelian\database\seeders\KondisiPembelianDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KondisiPembelian\Models\KondisiPembelian;
use Carbon\Carbon;
class KondisiPembelianDatabaseSeeder extends Seeder
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
         * KondisiPembelians Seed
         * ------------------
         */

        // DB::table('kondisipembelians')->truncate();
        // echo "Truncate: kondisipembelians \n";

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
        //         $data = KondisiPembelian::create($row);

        //     }


        KondisiPembelian::factory()->count(20)->create();
        $rows = KondisiPembelian::all();
        echo " Insert: kondisipembelians \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
