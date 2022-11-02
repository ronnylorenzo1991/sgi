<?php

namespace Database\Factories\Contributes\Entity;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(rand(7,9)),
            'description' => $this->faker->text(191),
        ];
    }
}
