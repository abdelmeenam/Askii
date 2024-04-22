<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the tags table
        DB::table('tags')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $languages = [
            'JavaScript', 'Python', 'Java', 'C++', 'Ruby', 'Swift', 'PHP', 'TypeScript', 'C#', 'Go',
            //            'React', 'Angular', 'Vue.js', 'Express.js', 'Django', 'Ruby on Rails', 'Spring', 'Laravel', 'Flask', 'ASP.NET'
        ];

        foreach ($languages as $language) {
            Tag::create([
                'name' => $language,
                'slug' => Str::slug($language),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    //php artisan db:seed --class=TagsTableSeeder

}
