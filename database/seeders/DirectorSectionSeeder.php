<?php

namespace Database\Seeders;

use App\Models\DirectorSection;
use Illuminate\Database\Seeder;

class DirectorSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $director_sections = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
                'description' => 'ddfdf',
                'image' => 'backend/media/setting/director_section/1720256096.jpg'
            ]

        ];

        DirectorSection::insert($director_sections);
    }
}
