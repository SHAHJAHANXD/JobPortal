<?php

namespace Database\Seeders;

use App\Models\HomePageSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HomePageSetting::create([
            'Facebook' => 'Enter Url here...',
            'Twitter' => 'Enter Url here...',
            'YouTube' => 'Enter Url here...',
            'Instagram' => 'Enter Url here...',
            'Whatsapp' => 'Enter Url here...',
        ]);
    }
}
