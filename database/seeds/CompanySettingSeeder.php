<?php

namespace Database\Seeders;

use App\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       if (!CompanySetting::exists()){
           $setting=new CompanySetting();
           $setting->company_name='MAX Company';
           $setting->company_email='max1990@gmail.com';
           $setting->company_phone='095193676';
           $setting->company_address='No.(20)Tarmwe gyi, Ka Gyi Quarter,Yangon';
           $setting->office_start_time='09:00:00';
           $setting->office_end_time='17:00:00';
           $setting->bread_start_time='12:00:00';
           $setting->bread_end_time='13:00:00';
           $setting->save();
       }
    }
}
