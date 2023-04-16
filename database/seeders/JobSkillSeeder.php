<?php

namespace Database\Seeders;

use App\Models\JobSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            0 => 'Laravel',
            1 => 'PHP',
            2 => 'React Native',
            3 => 'Flutter',
            4 => 'Android',
            5 => 'IOS',
            6 => 'Swift',
            7 => 'Kotlin',
            8 => 'HTML',
            9 => 'Bootstrap',
            10 => 'JavaScript',
            11 => 'React Js',
            12 => 'Vue Js',
            13 => 'Angular Js',
            14 => 'Node Js',
            15 => 'Express Js',
            16 => 'MERN',
            17 => 'SEO Expert',
            18 => 'Digital Marketer',
            19 => 'Project Manager',
            20 => 'HR',
        ];
        foreach ($skills as $key => $value) {
            JobSkill::create([
                'name' => $value,
            ]);
        }
    }
}
