<?php

namespace App\Models\Availability\Repository;

use App\Models\Availability\Entity\Availability;
use App\Models\Shared\Repository\SharedRepositoryEloquent;
use Carbon\Carbon;

class AvailabilityRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Availability $entity
    )
    {
        parent::__construct($entity);
    }

    public function getTodayAvailabilities() {
        return $this->entity->whereDate('created_at', Carbon::today())->get();
    }
}
