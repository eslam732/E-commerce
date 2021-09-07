<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->randomElement([1,10]),
            'status' => $this->faker->randomElement(['available','unavailable']),
            'image' => $this->faker->randomElement(['1.png','2.png','3.png','3.png']),
            'seller_id' => User::all()->random()->id,
        ];
    }
}
