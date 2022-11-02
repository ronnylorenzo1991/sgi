<?php

namespace App\Models\Subcategories\Repository;

use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Subcategories\Entity\Subcategory;

class SubcategoryRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Subcategory $entity
    )
    {
        parent::__construct($entity);
    }
}
