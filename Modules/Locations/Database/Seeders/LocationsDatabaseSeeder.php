<?php

namespace Modules\Locations\Database\Seeders;
use Modules\Locations\Entities\Locations;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class LocationsDatabaseSeeder extends Seeder
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
                'id'        => 1,
                'name'        => 'Gedung A',
                'parent_id'        => null,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'        => 2,
                'name'        => 'Gudang 1 GA',
                'parent_id'        => 1,
                'status'        =>  1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'        => 3,
                'name'        => 'Gudang 2 GA',
                'parent_id'        => 1,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], [
                'id'        => 4,
                'name'        => 'Gudang 3 GA',
                'parent_id'        => 1,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'        => 5,
                'name'        => 'Gedung B',
                'parent_id'        => null,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], [
                'id'        => 6,
                'name'        => 'Gudang 1 GB',
                'parent_id'        => 5,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], [
                'id'        => 7,
                'name'        => 'Gudang 2 GB',
                'parent_id'        => 5,
                'status'        =>   1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],

        ];

        foreach ($users as $user_data) {
            $user = Locations::create($user_data);

        }
    }
}
