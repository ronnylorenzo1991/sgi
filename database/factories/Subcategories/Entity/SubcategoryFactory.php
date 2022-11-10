<?php

namespace Database\Factories\Subcategories\Entity;

use App\Models\Categories\Entity\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(rand(5,8)),
            'description' => $this->faker->text(191),
            'status' => rand(0,1),
            'category_id' => Category::inRandomOrder()->where('status', 1)->first()->id,
        ];
    }
}
