<?php

namespace Database\Factories\InternetLinks\Entity;

use Illuminate\Database\Eloquent\Factories\Factory;

class InternetLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->text(191)
        ];
    }
}
