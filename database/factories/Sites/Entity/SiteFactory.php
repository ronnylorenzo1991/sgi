<?php

namespace Database\Factories\Sites\Entity;

use App\Models\Countries\Entity\country;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->company(),
            'description' => $this->faker->text(191),
        ];
    }
}
