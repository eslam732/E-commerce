<?php

namespace Database\Factories;

use App\Models\buyer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {



        return [


            'quantity' => $this->faker->randomElement([1, 3]),

            'buyer_id' => User::all()->random()->id,
            'product_id' => Product::all()->random()->id,
        ];
    }
}
