<?php

namespace Database\Factories\ReportTypes\Entity;

use App\Models\Countries\Entity\country;
use App\Models\Ips\Entity\Ip;
use App\Models\ReportTypes\Entity\ReportType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReportTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReportType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => 'salida informativa',
            'description' => 'salida informativa',
        ];
    }
}
