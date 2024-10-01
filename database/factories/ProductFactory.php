<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'user_id' => User::where('role', 'admin')->first()?->id,
            'category_id' => fn() => Category::inRandomOrder()->first()?->id,
            'country_id' => fn() => Country::inRandomOrder()->first()?->id,
            'status' => fake()->randomElement(array_column(ProductStatus::cases(), 'value')),
        ];
    }
}
