<?php

namespace Database\Factories\Ministries\Entity;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MinistryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => strtoupper(Str::random(rand(4,5))),
            'description' => $this->faker->text(191)
        ];
    }
}
