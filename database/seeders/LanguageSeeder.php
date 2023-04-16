<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Languages = [
            0 => 'Urdu',
            1 => 'English',
            2 => 'Punjabi',
            3 => 'Saraki',
            4 => 'Pashto',
        ];
        foreach ($Languages as $key => $value) {
            Language::create([
                'name' => $value,
            ]);
        }
    }
}
