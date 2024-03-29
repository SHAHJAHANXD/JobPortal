<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(JobSkillSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(HomePageSeeder::class);
    }
}
