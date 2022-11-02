<?php

namespace Database\Factories\Entities\Entity;

use App\Models\Countries\Entity\country;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = country::inRandomOrder()->first();
        return [
            'name'        => $this->faker->company(),
            'description' => $this->faker->text(191),
            'country_id'  => $country->id,
        ];
    }
}
