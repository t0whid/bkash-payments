<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = ["Laptop", "Mobile", "Watch", "Printer", "Mouse"];
        static $invoice = 20;
        $faker = Faker::create();

        return [
            'product_name' => $products[rand(0, 4)],
            'currency' => "BDT",
            'amount' => $faker->randomFloat(2, 10, 1000),
            'invoice' => $invoice++,
            'status' => "pending",
        ];
    }
}
