<?php

namespace App\Models\Categories\Repository;

use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Categories\Entity\Category;

class CategoryRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Category $entity
    )
    {
        parent::__construct($entity);
    }
}
