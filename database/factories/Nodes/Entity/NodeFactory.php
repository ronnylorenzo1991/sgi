<?php

namespace Database\Factories\Nodes\Entity;

use App\Models\Countries\Entity\country;
use App\Models\Entities\Entity\Entity;
use App\Models\InternetLinks\Entity\InternetLink;
use App\Models\Ips\Entity\Ip;
use App\Models\Ministries\Entity\Ministry;
use Illuminate\Database\Eloquent\Factories\Factory;

class NodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ip = Ip::factory()->create();
        $entity = Entity::factory()->create();
        $ministry = Ministry::factory()->create();
        $internetLink = InternetLink::factory()->create();
        $nationalCountryId = country::where('name', 'Cuba')->first()->id;

        return [
            'ip_id' => $ip->id,
            'entity_id' => $entity->id,
            'ministry_id' => $ministry->id,
            'internet_link_id' => $internetLink->id,
            'country_id' => country::inRandomOrder()->first()->id > $nationalCountryId ? country::inRandomOrder()->first()->id : $nationalCountryId,
        ];
    }
}
