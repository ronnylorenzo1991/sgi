<?php

namespace App\Models\InternetLinks\Repository;

use App\Models\Entities\Entity\Entity;
use App\Models\InternetLinks\Entity\InternetLink;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class InternetLinkRepository extends SharedRepositoryEloquent
{
    public function __construct(
        InternetLink $entity
    ) {
        parent::__construct($entity);
    }
}
