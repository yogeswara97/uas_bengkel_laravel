<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::create(null, 1, 1); // 1st January of this year
        $endDate = Carbon::create(null, 7, 4)->endOfDay(); // 4th July of this year, end of the day

        return [
            'customer_id' => Customer::factory(),
            'total_price' => $this->faker->randomFloat(2, 10, 500),
            'order_date' => $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that the model should have order items.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withItems()
    {
        return $this->afterCreating(function (Order $order) {
            OrderItem::factory()->count(3)->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
