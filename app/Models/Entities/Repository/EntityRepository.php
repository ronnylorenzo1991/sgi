<?php

namespace App\Models\Entities\Repository;

use App\Models\Entities\Entity\Entity;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class EntityRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Entity $entity
    ) {
        parent::__construct($entity);
    }
}
