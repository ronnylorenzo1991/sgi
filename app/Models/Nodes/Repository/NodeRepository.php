<?php

namespace App\Models\Nodes\Repository;

use App\Models\Nodes\Entity\Node;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class NodeRepository extends SharedRepositoryEloquent
{
    private $nodeRepository;

    public function __construct(
        Node $entity
    )
    {
        parent::__construct($entity);
    }
}
