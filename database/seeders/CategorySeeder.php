<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobType = [
            0 => 'Accounting / Finance',
            1 => 'Marketing',
            2 => 'Design',
            3 => 'Development',
            4 => 'Human Resource',
            5 => 'Project Management',
            6 => 'Customer Service',
            7 => 'Health and Care',
            8 => 'Automotive Jobs',
        ];
        foreach ($jobType as $key => $value) {
            Category::create([
                'name' => $value,
            ]);
        }
    }
}
