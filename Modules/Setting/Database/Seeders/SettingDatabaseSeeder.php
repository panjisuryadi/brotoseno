<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'company_name' => 'Hokkie POS',
            'company_email' => 'info@official-gtds.com',
            'company_phone' => '012345678901',
            'notification_email' => 'notification@test.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'bg_sidebar' => '#ee0086',
            'bg_sidebar_hover' => '#FFC82B',
            'bg_sidebar_aktif' => '#f7d584',
            'bg_sidebar_link' => '#fff',
            'bg_sidebar_link_hover' => '#333',
            'link_color' => '#ee0086',
            'link_hover' => '#ee0086',
            'header_color' => '#ee0086',
            'btn_color' => '#ee0086',
            'btn_cancel' => '#c41c10',
            'btn_sukses' => '#0b8c4d',
            'footer_text' => 'Hokkie POS © 2021 || Developed by Global tekno digital Solusi',
            'company_address' => 'Bandung, Indonesia'
        ]);
    }

    


}

