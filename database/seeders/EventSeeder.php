<?php

namespace Database\Seeders;

use App\Models\Categories\Entity\Category;
use App\Models\Events\Entity\Event;
use App\Models\Nodes\Entity\Node;
use App\Models\Sources\Entity\Source;
use App\Models\Subcategories\Entity\Subcategory;
use Database\Factories\Events\Entity\EventFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = Event::factory(50)->create();

        foreach ($events as $event) {
            $event->nodes()->attach(Node::inRandomOrder()->first()->id, array('is_source' => 1));
            $event->nodes()->attach(Node::inRandomOrder()->where('country_id', 57)->first()->id ?? Node::inRandomOrder()->first()->id, array('is_source' => 1));
            $event->nodes()->attach(Node::inRandomOrder()->first()->id, array('is_source' => false));
        }
    }
}
