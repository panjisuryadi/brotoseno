<?php

namespace Modules\Locations\Database\Seeders;
use Modules\Locations\Entities\UsersLocations;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class UsersLocationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Model::unguard();

            $users = [
            [
                'user_id'        => 6,
                'id_location'        => 5,
                'sub_location'        => 6,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], [
                'user_id'        => 6,
                'id_location'        => 5,
                'sub_location'        => 7,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'user_id'        => 5,
                'id_location'        => 1,
                'sub_location'        => 2,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], [
                'user_id'        => 5,
                'id_location'        => 1,
                'sub_location'        => 3,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
              [
                'user_id'        => 5,
                'id_location'        => 1,
                'sub_location'        => 4,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],


        ];

        foreach ($users as $user_data) {
            $user = UsersLocations::create($user_data);

        }
    }
}
