<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobType = [
            0 => 'Freelance',
            1 => 'Full Time',
            2 => 'Part Time',
            3 => 'Temporary',
        ];
        foreach ($jobType as $key => $value) {
            JobType::create([
                'name' => $value,
            ]);
        }
    }
}
