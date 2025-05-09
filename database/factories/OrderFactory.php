<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            // 'tenant_id' => null, // multi tenancy
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            // 'shipment_id' => null,

            'order_email' => $this->faker->unique()->safeEmail(),
            'order_name' => $this->faker->name(),

            // 'order_address' => null,
            // 'order_bus' => null,
            // 'order_postcode' => null,
            // 'order_city' => null,

            'order_status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'cancelled']),
            'order_taxes' => $this->faker->randomFloat(2, 0, 10),
            'order_total' => $this->faker->randomFloat(2, 10, 500),
            // 'order_total_with_ship' => null,
        ];
    }
}
