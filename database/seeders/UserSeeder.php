<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'Admin',
            'status' => '1',
            'email_status' => '1',
            'account_status' => '1',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Employer',
            'email' => 'admin@employer.com',
            'role' => 'Employer',
            'status' => '1',
            'email_status' => '1',
            'account_status' => '1',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Candidate',
            'email' => 'admin@candidate.com',
            'role' => 'Candidate',
            'status' => '1',
            'email_status' => '1',
            'account_status' => '1',
            'password' => bcrypt('12345678'),
        ]);
    }
}
