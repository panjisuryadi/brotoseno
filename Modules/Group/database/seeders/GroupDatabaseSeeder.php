<?php

namespace Modules\Group\database\seeders;
//use Modules\Group\database\seeders\GroupDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Group\Models\Group;
use Carbon\Carbon;
class GroupDatabaseSeeder extends Seeder
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
         * Groups Seed
         * ------------------
         */

        // DB::table('groups')->truncate();
        // echo "Truncate: groups \n";

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
        //         $data = Group::create($row);

        //     }


        Group::factory()->count(20)->create();
        $rows = Group::all();
        echo " Insert: groups \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
