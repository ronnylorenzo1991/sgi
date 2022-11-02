<?php

namespace App\Models\Ips\Repository;

use App\Models\Ips\Entity\Ip;
use App\Models\Nodes\Repository\NodeRepository;
use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Events\Entity\Event;

class IpRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Ip $entity
    ) {
        parent::__construct($entity);
    }
}
