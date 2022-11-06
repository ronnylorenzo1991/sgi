<?php

namespace App\Models\Reports\Repository;

use App\Models\Reports\Entity\Report;
use App\Models\Shared\Repository\SharedRepositoryEloquent;

class ReportRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Report $entity
    ) {
        parent::__construct($entity);
    }

    public function store($data)
    {
        $report = $this->entity->create(array_diff_key($data, array_flip(['todayData'])));

        $events = $data['todayData']['events'];
        $news = $data['todayData']['news'];
        $availabilities = $data['todayData']['availabilities'];

        foreach ($events as $event) {
            $report->events()->attach($event['id']);
        }

        foreach ($news as $new) {
            $report->news()->attach($new['id']);
        }

        foreach ($availabilities as $availability) {
            $report->availabilities()->attach($availability['id']);
        }
    }

    public function update($data, $id)
    {
        $report = $this->entity->findOrFail($id);
        $report->update(array_diff_key($data, array_flip(['todayData'])));;

        $events = [];
        $news = [];
        $availabilities = [];

        foreach ($data['todayData']['events'] as $event) {
            $events[] = $event['id'];
        }
        $report->events()->sync($events);

        foreach ($data['todayData']['news'] as $new) {
            $news[] = $new['id'];
        }
        $report->news()->sync($news);

        foreach ($data['todayData']['availabilities'] as $availability) {
            $availabilities[] = $availability['id'];
        }
        $report->availabilities()->sync($availabilities);
    }
}
