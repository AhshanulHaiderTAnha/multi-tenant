<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {

            $products = Product::inRandomOrder()->whereNotNull('price')->take(rand(2, 5))->get();

            foreach ($products as $product) {

                // Als price toch leeg blijkt → creeër nieuwe product
                if (!$product->price) {
                    $product = Product::factory()->create([
                        'price' => rand(10, 500),
                    ]);
                }

                $price = $product->price;
                $taxes = round($price * 0.21, 2);
                $quantity = rand(1, 3);

                $price_with_tax = $price + $taxes;
                $product_total = $price_with_tax * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'product_price' => $price,
                    'product_taxes' => $taxes,
                    'product_total' => $product_total,
                ]);

            }
        }
    }
}
