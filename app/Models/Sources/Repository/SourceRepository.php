<?php

namespace App\Models\Sources\Repository;

use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Sources\Entity\Source;

class SourceRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Source $entity
    ) {
        parent::__construct($entity);
    }
}
