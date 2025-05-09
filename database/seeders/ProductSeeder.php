<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                //'tenant_id' => 1,
                'category_id' => rand(1, 5),
                'name' => "Test Product $i",
                'slug' => Str::slug("Test Product $i"),
                'description' => "Beschrijving voor product $i",
                'price' => rand(10, 100),
                'stock' => rand(1, 100),
                'images' => json_encode(['uploads/products/dummy.jpg']),
            ]);
        }
    }
}
