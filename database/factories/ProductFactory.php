<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->withFaker()->words(mt_rand(1,3), true)),
            'price' => mt_rand(10,200) * 10,
            'quantity' => mt_rand(5,30),
            //'price' => $this->withFaker()->randomNumber(4, false) * 10,
            //'quantity' => $this->withFaker()->randomNumber(3, false),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
