<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();

        if (!$product) {
            $product = Product::factory()->create([
                'price' => rand(10, 500),
            ]);
        }

        $price = $product->price;
        $taxes = round($price * 0.21, 2);
        $quantity = $this->faker->numberBetween(1, 5);

        // FIX HIER:
        $price_with_tax = $price + $taxes;
        $total = $price_with_tax * $quantity;

        return [
            // 'tenant_id' => null, // multi tenancy
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'product_price' => $price,
            'product_taxes' => $taxes,
            'product_total' => $total,
        ];
    }
}
