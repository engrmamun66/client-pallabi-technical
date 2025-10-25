<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $about_sections = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
                'description' => 'ddfdf',
                'mission' => 'mission',
                'vision' => 'vision',
                'image' => 'backend/media/setting/about_section/1720256096.jpg'
            ]

        ];

        AboutSection::insert($about_sections);
    }
}
