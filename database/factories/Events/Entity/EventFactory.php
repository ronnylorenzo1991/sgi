<?php

namespace Database\Factories\Events\Entity;

use App\Models\Categories\Entity\Category;
use App\Models\Contributes\Entity\Contribute;
use App\Models\Events\Entity\Event;
use App\Models\Sources\Entity\Source;
use App\Models\Subcategories\Entity\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subcategory = Subcategory::inRandomOrder()->where('status', 1)->first();

        return [
            'number'         => Str::random(5),
            'observations'   => $this->faker->sentence(),
            'date'           => $this->faker->dateTimeBetween("2022/01/01", "2022/12/31"),
            'subcategory_id' => $subcategory->id,
            'category_id'    => $subcategory->category_id,
            'detected_by_id' => Source::inRandomOrder()->first()->id,
            'contribute_id'  => Contribute::inRandomOrder()->first()->id,
        ];
    }
}
