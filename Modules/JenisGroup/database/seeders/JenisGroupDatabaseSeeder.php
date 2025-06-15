<?php

namespace Modules\JenisGroup\database\seeders;
//use Modules\JenisGroup\database\seeders\JenisGroupDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisGroup\Models\JenisGroup;
use Carbon\Carbon;
class JenisGroupDatabaseSeeder extends Seeder
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
         * JenisGroups Seed
         * ------------------
         */

        // DB::table('jenisgroups')->truncate();
        // echo "Truncate: jenisgroups \n";

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
        //         $data = JenisGroup::create($row);

        //     }


        JenisGroup::factory()->count(20)->create();
        $rows = JenisGroup::all();
        echo " Insert: jenisgroups \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
