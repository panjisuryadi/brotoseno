<?php

namespace Modules\UserCabang\database\seeders;
//use Modules\UserCabang\database\seeders\UserCabangDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\UserCabang\Models\UserCabang;
use Carbon\Carbon;
class UserCabangDatabaseSeeder extends Seeder
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
         * UserCabangs Seed
         * ------------------
         */

        // DB::table('usercabangs')->truncate();
        // echo "Truncate: usercabangs \n";

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
        //         $data = UserCabang::create($row);

        //     }


        UserCabang::factory()->count(20)->create();
        $rows = UserCabang::all();
        echo " Insert: usercabangs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
