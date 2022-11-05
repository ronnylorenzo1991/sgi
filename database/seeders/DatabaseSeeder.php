<?php

namespace Database\Seeders;

use App\Models\Categories\Entity\Category;
use App\Models\Contributes\Entity\Contribute;
use App\Models\Events\Entity\Event;
use App\Models\Ips\Entity\Ip;
use App\Models\Nodes\Entity\Node;
use App\Models\Sites\Entity\Site;
use App\Models\Sources\Entity\Source;
use App\Models\Subcategories\Entity\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CategorySeeder::class);

        Node::factory(10)->create();
        Source::factory(10)->create();
        Contribute::factory(10)->create();
        Site::factory(10)->create();

        $this->call(EventSeeder::class);
    }
}
