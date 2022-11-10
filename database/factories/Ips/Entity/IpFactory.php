<?php

namespace Database\Factories\Ips\Entity;

use App\Models\Countries\Entity\country;
use App\Models\Ips\Entity\Ip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->ipv4,
        ];
    }
}
