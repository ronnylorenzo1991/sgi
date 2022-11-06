<?php

namespace App\Models\News\Repository;

use App\Models\News\Entity\News;
use App\Models\Shared\Repository\SharedRepositoryEloquent;
use Carbon\Carbon;

class NewsRepository extends SharedRepositoryEloquent
{
    public function __construct(
        News $entity
    ) {
        parent::__construct($entity);
    }

    public function getTodayNews() {
        return $this->entity->whereDate('created_at', Carbon::today())->get();
    }
}
