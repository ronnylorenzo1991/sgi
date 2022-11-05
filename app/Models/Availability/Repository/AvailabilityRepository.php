<?php

namespace App\Models\Availability\Repository;

use App\Models\Availability\Entity\Availability;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class AvailabilityRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Availability $entity
    )
    {
        parent::__construct($entity);
    }
}
