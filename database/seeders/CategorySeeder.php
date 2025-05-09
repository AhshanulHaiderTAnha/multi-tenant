<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Courses',
            'Accounts',
            'Design',
            'Web Development',
            'Mobile Development',
            'Outreach Data',
        ];

        //Het zoekt naar een category met de naam $name.
        //Als die niet bestaat, wordt hij aangemaakt.
        //Als hij al bestaat, gebeurt er niets.
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => null, // Kun je aanpassen indien gewenst
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
