<?php

namespace App\Models\Ministries\Repository;

use App\Models\Ministries\Entity\Ministry;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class MinistryRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Ministry $entity
    ) {
        parent::__construct($entity);
    }
}
