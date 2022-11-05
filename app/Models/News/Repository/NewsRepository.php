<?php

namespace App\Models\News\Repository;

use App\Models\News\Entity\News;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class NewsRepository extends SharedRepositoryEloquent
{
    public function __construct(
        News $entity
    ) {
        parent::__construct($entity);
    }
}
