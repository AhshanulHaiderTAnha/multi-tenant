<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eerst Users seeden als die nog leeg is
        if (User::count() == 0) {
            User::factory()->count(20)->create();
        }

        // Dan pas orders aanmaken
        Order::factory()->count(25)->create();

    }
}
