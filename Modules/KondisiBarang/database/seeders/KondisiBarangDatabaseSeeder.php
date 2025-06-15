<?php

namespace Modules\KondisiBarang\database\seeders;
//use Modules\KondisiBarang\database\seeders\KondisiBarangDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KondisiBarang\Models\KondisiBarang;
use Carbon\Carbon;
class KondisiBarangDatabaseSeeder extends Seeder
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
         * KondisiBarangs Seed
         * ------------------
         */

        // DB::table('kondisibarangs')->truncate();
        // echo "Truncate: kondisibarangs \n";

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
        //         $data = KondisiBarang::create($row);

        //     }


        KondisiBarang::factory()->count(20)->create();
        $rows = KondisiBarang::all();
        echo " Insert: kondisibarangs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
