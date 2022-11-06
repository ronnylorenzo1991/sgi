<?php

namespace App\Models\ReportTypes\Repository;

use App\Models\ReportTypes\Entity\ReportType;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class ReportTypeRepository extends SharedRepositoryEloquent
{
    public function __construct(
        ReportType $entity
    ) {
        parent::__construct($entity);
    }
}
