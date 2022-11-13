<?php

namespace App\Models\Reports\Repository;

use App\Models\Reports\Entity\Report;
use App\Models\Shared\Repository\SharedRepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository extends SharedRepositoryEloquent
{
    public function __construct(
        Report $entity
    ) {
        parent::__construct($entity);
    }

    public function store($data)
    {
        $data['start_date'] = Carbon::parse($data['startDate'] ?? null);
        $data['end_date'] = Carbon::parse($data['endDate'] ?? null);
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

    public function getAllFiltered($filters)
    {
        $query = $this->entity->query()->with('events');

        [$sortBy, $sortDir] = $this->getOrderByData($filters);

        $perPage = in_array('per_page', $filters) ? $filters['per_page'] : 10;
        $page = array_key_exists('page', $filters) ? $filters['page'] : 1;

        $startDate = Carbon::parse($filters['dateRange']['startDate'] ?? null)->startOfDay();
        $endDate = Carbon::parse($filters['dateRange']['endDate'] ?? null)->endOfDay();

        if ($filters['dateRange'] ?? null) {
            $query->whereBetween('reports.created_at', [$startDate, $endDate]);
        }

        if ($filters['number'] ?? null) {
            $query->where('reports.number', 'like', $filters['number']);
        }

        if (($filters['category_id'] ?? null) || ($filters['subcategory_id'] ?? null) || ($filters['node_entity_id'] ?? null) || ($filters['node_ministry_id'] ?? null)) {
            $query->join('event_report', function($query) {
                $query->on('event_report.report_id', 'reports.id')
                    ->join('events', 'event_report.event_id', 'events.id')
                    ->join('event_node', 'event_node.event_id', 'events.id')
                    ->join('nodes', 'nodes.id', 'event_node.node_id');
            });
        }

        if ($filters['category_id'] ?? null) {
            $query->where('category_id', $filters['category_id']);
        }

        if ($filters['subcategory_id'] ?? null) {
            $query->where('subcategory_id', $filters['subcategory_id']);
        }

        if ($filters['node_entity_id'] ?? null) {
            $query->where('nodes.entity_id', $filters['node_entity_id']);
        }

        if ($filters['node_ministry_id'] ?? null) {
            $query->where('nodes.ministry_id', $filters['node_ministry_id']);
        }


        $query->select(
            'reports.id',
            'reports.created_at',
            'reports.number',
            'reports.start_date',
            'reports.end_date',
        );

        return $query->orderBy($sortBy, $sortDir)->groupBy('reports.id')->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    private function getOrderByData($filters)
    {
        $sortData = $filters['sort'] ?? null ? preg_split("/[\s|]+/", $filters['sort']) : [];

        if (!empty($sortData)) {
            $sortBy = $sortData[0];
            $sortDir = $sortData[1];

            return [$sortBy, $sortDir];
        }

        $sortBy = array_key_exists('order_by',
            $filters) && $filters['order_by'] != null && $filters['order_by'] != 'undefined' ? $filters['order_by'] : 'id';
        $sortDir = array_key_exists('sort_by',
            $filters) && $filters['sort_by'] != null && $filters['sort_by'] != 'undefined' ? $filters['sort_by'] : 'desc';

        return [$sortBy, $sortDir];
    }

    public function update($data, $id)
    {
        $data['start_date'] = Carbon::parse($data['startDate'] ?? null);
        $data['end_date'] = Carbon::parse($data['endDate'] ?? null);

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

    public function getWithTotalText($id, $model)
    {
        $text = '';
        $query = $this->entity->where('reports.id', $id)
            ->join('event_report', 'report_id', 'reports.id')
            ->join('events', 'events.id', 'event_report.event_id');

        if ($model == 'category') {
            $query = $query->join('categories', 'categories.id', 'events.category_id')
                ->select(
                    'categories.name',
                    DB::Raw('COUNT(categories.id) as count'),
                )->groupBy('categories.name')->get();
        }

        if ($model == 'entity') {
            $query = $query->join('entities', 'entities.id', 'events.detected_by_id')
                ->select(
                    'entities.name',
                    DB::Raw('COUNT(entities.id) as count'),
                )->groupBy('entities.name')->get();
        }

        foreach ($query as $key => $item) {
            $text = $text.' '.$item->name.' '.$item->count;

            if (!$key == count($query) - 1) {
                $text = $text.',';
            }
        }

        return $text;
    }

    public function getNewsFormatted($id)
    {
        $query = $this->entity->where('reports.id', $id)
            ->join('news_report', 'report_id', 'reports.id')
            ->join('news', 'news.id', 'news_report.news_id')
            ->select('title as news_title', 'body as news_body', 'url as news_url')->get();

        return $query->toArray();
    }

    public function getTrojanEvents($id, $type)
    {
        $events = [];
        Report::where('id', $id)->with('events')->each(function ($item) use (&$events, $type) {
            foreach ($item->events as $event) {
                $condition = $type == 'source' ? $event->national_as_source : !$event->national_as_source;
                if ($event->category_id === get_trojan_category_id() && $condition) {
                    $nationalsEntitiesData = '';
                    $foreignEntitiesData = '';
                    if ($event->nationalNodes->count()) {
                        $entitiesByMinistry = [];
                        foreach ($event->nationalNodes as $key => $node) {
                            if($node->ministry->name ?? null) {
                                if (in_array($node->ministry->name , $entitiesByMinistry)) {
                                    $entitiesByMinistry[$node->ministry->name][] = $node->entity->name;
                                } else {
                                    $entitiesByMinistry[] = [
                                        $node->ministry->name => [$node->entity->name],
                                    ];
                                }
                            }
                        }

                        foreach ($entitiesByMinistry as $key => $item) {
                            $nationalsEntitiesData = $nationalsEntitiesData.' '.array_keys($item)[0].' (';
                            foreach ($item as $subKey => $subItem) {
                                $nationalsEntitiesData = $nationalsEntitiesData.$subItem[0];
                                if (!$subKey != count($item) - 1) {
                                    $nationalsEntitiesData = $nationalsEntitiesData.',';
                                } else {
                                    $nationalsEntitiesData = $nationalsEntitiesData.')';
                                }
                            }
                        }
                    }

                    if ($event->foreignNodes->count()) {
                        $entitiesByCountry = [];
                        foreach ($event->foreignNodes as $key => $node) {
                            if($node->country->name ?? null) {
                                if (in_array($node->country->name ?? null, $entitiesByCountry)) {
                                    $entitiesByCountry[$node->country->name][] = $node->entity->name;
                                } else {
                                    $entitiesByCountry[] = [
                                        $node->country->name => [$node->entity->name],
                                    ];
                                }
                            }
                        }
                        foreach ($entitiesByCountry as $key => $item) {
                            $foreignEntitiesData = $foreignEntitiesData.' '.array_keys($item)[0].' (';
                            foreach ($item as $subKey => $subItem) {
                                $foreignEntitiesData = $foreignEntitiesData.$subItem[0];
                                if (!$subKey != count($item) - 1) {
                                    $foreignEntitiesData = $foreignEntitiesData.',';
                                } else {
                                    $foreignEntitiesData = $foreignEntitiesData.')';
                                }
                            }
                        }
                    }
                    $trojanEvent = [
                        'event_number'           => $event->number,
                        'event_category'         => $event->category->name,
                        'event_observations'     => $event->observations,
                        'entities_by_ministries' => $nationalsEntitiesData,
                        'entities_by_countries'  => $foreignEntitiesData,
                    ];


                    $trojanEvent['national_preposition'] = count($event->nationalNodes) > 1 ? 'direcciónes asignadas' : 'una dirección asignada';
                    $trojanEvent['foreign_preposition'] = count($event->foreignNodes) > 1 ? 'direcciónes asignadas' : 'una dirección asignada';
                    $events[] = $trojanEvent;
                }
            }
        });

        return $events;
    }

    public function getEvents($id, $type)
    {
        $events = [];
        Report::where('id', $id)->with('events')->each(function ($item) use (&$events, $type) {
            foreach ($item->events as $event) {
                if ($event->category_id !== get_trojan_category_id() && ($type == 'source' ? $event->national_as_source : !$event->national_as_source)) {
                    $nationalsEntitiesData = '';
                    $foreignEntitiesData = '';
                    if ($event->nationalNodes->count()) {
                        $entitiesByMinistry = [];
                        foreach ($event->nationalNodes as $key => $node) {
                            if (in_array($node->ministry->name ?? null, $entitiesByMinistry)) {
                                $entitiesByMinistry[$node->ministry->name][] = $node->entity->name;
                            } else {
                                $entitiesByMinistry[] = [
                                    $node->ministry->name ?? null => [$node->entity->name ?? null],
                                ];
                            }
                        }
                        foreach ($entitiesByMinistry as $key => $item) {
                            $nationalsEntitiesData = $nationalsEntitiesData.' '.array_keys($item)[0].' (';
                            foreach ($item as $subKey => $subItem) {
                                $nationalsEntitiesData = $nationalsEntitiesData.$subItem[0];
                                if (!$subKey != count($item) - 1) {
                                    $nationalsEntitiesData = $nationalsEntitiesData.',';
                                } else {
                                    $nationalsEntitiesData = $nationalsEntitiesData.')';
                                }
                            }
                        }
                    }

                    if (count($event->foreignNodes)) {
                        $entitiesByCountry = [];
                        foreach ($event->foreignNodes as $key => $node) {
                            if (in_array($node->ministry->name ?? null, $entitiesByCountry)) {
                                $entitiesByCountry[$node->country->name][] = $node->entity->name ?? null;
                            } else {
                                $entitiesByCountry[] = [
                                    $node->country->name ?? null => [$node->entity->name ?? null],
                                ];
                            }
                        }
                        foreach ($entitiesByCountry as $key => $item) {
                            $foreignEntitiesData = $foreignEntitiesData.' '.array_keys($item)[0].' (';
                            foreach ($item as $subKey => $subItem) {
                                $foreignEntitiesData = $foreignEntitiesData.$subItem[0];
                                if (!$subKey != count($item) - 1) {
                                    $foreignEntitiesData = $foreignEntitiesData.',';
                                } else {
                                    $foreignEntitiesData = $foreignEntitiesData.')';
                                }
                            }
                        }
                    }
                    $commonEvent = [
                        'event_number'           => $event->number,
                        'event_category'         => $event->category->name,
                        'event_subcategory'      => $event->subcategory->name,
                        'entities_by_ministries' => $nationalsEntitiesData,
                        'entities_by_countries'  => $foreignEntitiesData,
                    ];

                    $commonEvent['national_preposition'] = count($event->nationalNodes) > 1 ? 'direcciónes asignadas' : 'una dirección asignada';
                    $commonEvent['foreign_preposition'] = count($event->foreignNodes) > 1 ? 'direcciónes asignadas' : 'una dirección asignada';

                    $events[] = $commonEvent;
                }
            }
        });

        return $events;
    }

    public function getAvailabilitiesChartData($id) {
        $report = $this->findOrFail($id);
        $labels = [];
        $series = [];
        foreach ($report->availabilities as $availability) {
            $labels[] = $availability->site->name;
            $series[] = $availability->availability;
        }

        return ['labels' => $labels, 'series' => $series];
    }

    public function getCategoriesChartData($id) {
        $report = $this->findOrFail($id);
        $labels = [];
        $series = [];
        foreach ($report->availabilities as $availability) {
            $labels[] = $availability->site->name;
            $series[] = $availability->availability;
        }

        return ['labels' => $labels, 'series' => $series];
    }

    public function getChartData($id, $model) {
        $labels = [];
        $series = [];

        $query = $this->entity->where('reports.id', $id)
            ->join('event_report', 'report_id', 'reports.id')
            ->join('events', 'events.id', 'event_report.event_id');

        if ($model == 'category') {
            $query = $query->join('categories', 'categories.id', 'events.category_id')
                ->select(
                    'categories.name',
                    DB::Raw('COUNT(categories.id) as count'),
                )->groupBy('categories.name')->get();
        }

        if ($model == 'entity') {
            $query = $query->join('entities', 'entities.id', 'events.detected_by_id')
                ->select(
                    'entities.name',
                    DB::Raw('COUNT(entities.id) as count'),
                )->groupBy('entities.name')->get();
        }

        $query->each(function($item) use (&$labels, &$series) {
           $labels[] = $item->name;
           $series[] = $item->count;
        });

        return ['labels' => $labels, 'series' => $series];
    }
}
