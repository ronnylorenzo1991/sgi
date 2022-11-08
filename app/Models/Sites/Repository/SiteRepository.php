<?php

namespace App\Models\Sites\Repository;

use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Sites\Entity\Site;

class SiteRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Site $entity
    )
    {
        parent::__construct($entity);
    }
}
