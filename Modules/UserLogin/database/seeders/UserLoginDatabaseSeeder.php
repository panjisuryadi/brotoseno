<?php

namespace Modules\UserLogin\database\seeders;
//use Modules\UserLogin\database\seeders\UserLoginDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\UserLogin\Models\UserLogin;
use Carbon\Carbon;
class UserLoginDatabaseSeeder extends Seeder
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
         * UserLogins Seed
         * ------------------
         */

        // DB::table('userlogins')->truncate();
        // echo "Truncate: userlogins \n";

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
        //         $data = UserLogin::create($row);

        //     }


        UserLogin::factory()->count(20)->create();
        $rows = UserLogin::all();
        echo " Insert: userlogins \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
