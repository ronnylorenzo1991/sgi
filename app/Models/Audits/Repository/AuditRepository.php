<?php

namespace App\Models\Audits\Repository;

use App\Models\Audits\Entity\Audit;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class AuditRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Audit $entity
    )
    {
        parent::__construct($entity);
    }
}
