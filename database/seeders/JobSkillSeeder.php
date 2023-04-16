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
        $url = [
            0 => 'https://laravel.com/img/logomark.min.svg',
            1 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/182px-PHP-logo.svg.png',
            2 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/React-icon.svg/768px-React-icon.svg.png?20220125121207',
            3 => 'https://logowik.com/content/uploads/images/flutter5786.jpg',
            4 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Android_logo_2019_%28stacked%29.svg/182px-Android_logo_2019_%28stacked%29.svg.png',
            5 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/63/IOS_wordmark_%282017%29.svg/113px-IOS_wordmark_%282017%29.svg.png',
            6 => 'https://developer.apple.com/assets/elements/icons/swift/swift-64x64_2x.png',
            7 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/Kotlin_Icon.svg/768px-Kotlin_Icon.svg.png?20171012085709',
            8 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/61/HTML5_logo_and_wordmark.svg/180px-HTML5_logo_and_wordmark.svg.png',
            9 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/180px-Bootstrap_logo.svg.png',
            10 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6a/JavaScript-logo.png/800px-JavaScript-logo.png',
            11 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/React-icon.svg/768px-React-icon.svg.png?20220125121207',
            12 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Vue.js_Logo_2.svg/1200px-Vue.js_Logo_2.svg.png',
            13 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/Angular_full_color_logo.svg/375px-Angular_full_color_logo.svg.png',
            14 => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Node.js_logo.svg/1200px-Node.js_logo.svg.png',
            15 => 'https://cdn.buttercms.com/2q5r816LTo2uE9j7Ntic',
            16 => 'https://upload.wikimedia.org/wikipedia/commons/9/94/MERN-logo.png',
            17 => 'https://img.freepik.com/free-vector/seo-analytics-team-concept-illustration_114360-9205.jpg?t=st=1681661254~exp=1681661854~hmac=62639698b213dc1cb2ecc81d18d4094eae14f192a300bc67a8452461977464e1',
            18 => 'https://img.freepik.com/free-vector/mobile-marketing-isometric-style_23-2148896785.jpg?t=st=1681661385~exp=1681661985~hmac=f5e09ac3516a0723bf9dd94dbbb1ba46cb6ece0d9a2c546f515fa101c37bf50a',
            19 => 'https://img.freepik.com/free-vector/business-group-people-illustration_52683-34770.jpg?t=st=1681661431~exp=1681662031~hmac=5dfce9400bfa2ed2662cdc2b961c29ab7cce5ef9dc47084df0b80e1915fd476d',
            20 => 'https://img.freepik.com/free-vector/choosing-best-candidate-concept_52683-43377.jpg?t=st=1681661458~exp=1681662058~hmac=5c03096a578f1c260834f304f4848f0954ac1566e525c786c59da1ddfdf6cc9b',
        ];
        foreach ($skills as $key => $value) {
            JobSkill::create([
                'name' => $value,
                'img' => $url[$key],
            ]);
        }
    }
}
