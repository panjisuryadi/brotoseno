<?php

namespace Database\Seeders;
use n0izestr3am\LicenseClient\Models\LicenseSerial;
use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

//php artisan db:seed --class=gtdsClientsSeeder

class gtdsClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
         $host = config('app.url');
         $name = config('app.name');
        // $date= strtotime(date('Y-m-d'));
         $clients = [
                   [
                    'id'                 => '1',
                    'name'               => $name,
                    'domain'             => $host,
                    'email'              => 'asep@gmailssasas.com',
                    'serial'             => '8d8d8-5566-555-66676',
                    'judul_notif'        => 'VPS Payment Reminder!',
                    'tgl_notif'          => 'Tagihan anda sudah jatuh tempo silahkan lakukan pembayaran',
                    'tgl_notif'          => 1,
                    'expired'            => Carbon::now(),
                     'date'              => Carbon::now(),
                     'created_at'        => Carbon::now(),
                     'updated_at'        => Carbon::now(),
                    ]

                ];
        LicenseSerial::insert($clients);
    }
}
