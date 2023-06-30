<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();

        foreach(range(1, 10) as $index){
            Blog::create([
                'title' => $faker->paragraph,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
