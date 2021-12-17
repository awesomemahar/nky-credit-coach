<?php

namespace Database\Seeders;

use App\Models\Bureau;
use App\Models\BusinessSetting;
use App\Models\Key;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'first_name' => 'Admin',
                'email' => 'admin@test.com',
                'type' => '1',
                'subscription_package_id'=>0,
                'password' => Hash::make('12345678'),
            ],
            [
                'first_name' => 'Business User',
                'email' => 'business@test.com',
                'type' => '2',
                'subscription_package_id'=>4,
                'subscription_status'=>1,
                'password' => Hash::make('12345678'),
            ],
            [
                'first_name' => 'John',
                'email' => 'client@test.com',
                'type' => '3',
                'password' => Hash::make('12345678'),
                'subscription_package_id'=>1,
                'subscription_status'=>1,
                'business_id'=>2
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }

        $bureaus = [
            [
                'title' => 'TransUnion',
                'slug' => 'transunion',
                'address' => 'TransUnion Consumer Solutions'. ' <br>' .'P.O. Box 2000'. ' <br> ' . 'Chester, PA 19016-2000 ',
            ],
            [
                'title' => 'Experian',
                'slug' => 'experian',
                'address' => 'Experian'. ' <br>' .'P.O. Box 4500'. ' <br> ' . 'Allen, TX 75013 ',
            ],
            [
                'title' => 'Equifax',
                'slug' => 'Equifax',
                'address' => 'Equifax Information Services, LLC'. ' <br>' .'P.O. Box 740256'. ' <br> ' . 'Atlanta, GA 30374',
            ],
        ];

        foreach ($bureaus as $value) {
            Bureau::create($value);
        }

        $settings = [
            [
                'type' => 'theme',
                'value' => 'light',
            ],
            [
                'type' => 'fax_client',
                'value' => '0',
            ]
        ];

        foreach ($settings as $setting) {
            BusinessSetting::create($setting);
        }


    }
}
