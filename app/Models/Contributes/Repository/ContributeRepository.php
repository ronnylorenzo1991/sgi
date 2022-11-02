<?php

namespace App\Models\Contributes\Repository;

use App\Models\Contributes\Entity\Contribute;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class ContributeRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Contribute $entity
    )
    {
        parent::__construct($entity);
    }
}
