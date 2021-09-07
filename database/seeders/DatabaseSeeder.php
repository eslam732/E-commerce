<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Product::truncate();
        Transaction::truncate();
        Category::truncate();
        DB::table('category_product')->truncate();
         
          \App\Models\Category::factory(10)->create();
         \App\Models\User::factory(10)->create();
         \App\Models\Product::factory(10)->create()
        ->each(function ($product){
            $categories=Category::all()->random(mt_rand(1,5))->pluck('id');
            $product->categories()->attach($categories);
       });
         \App\Models\Transaction::factory(10)->create();
         
         
         
    }
}
