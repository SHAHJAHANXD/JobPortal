<?php

namespace Database\Seeders;

use App\Models\AddressSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AddressSetting::create([
            'address' => 'Gulshan Iqbal, Rahim Yar Khan, PK',
            'email' => 'info@jobs.cybinix.com',
            'email' => '+92 318 750 7015',
        ]);
    }
}
