<?php

namespace App\Models\Events\Repository;

use App\Models\Countries\Entity\country;
use App\Models\Ips\Repository\IpRepository;
use App\Models\Nodes\Repository\NodeRepository;
use App\Models\Shared\Repository\SharedRepositoryEloquent;
use App\Models\Events\Entity\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventRepository extends SharedRepositoryEloquent
{
    private $nodeRepository;
    private $ipRepository;

    public function __construct(
        Event $entity,
        NodeRepository $nodeRepository,
        IpRepository $ipRepository
    ) {
        parent::__construct($entity);
        $this->nodeRepository = $nodeRepository;
        $this->ipRepository = $ipRepository;
    }

    public function store($data)
    {
        $event = $this->entity->create(array_diff_key($data, array_flip(['national_nodes', 'foreign_nodes'])));

        $foreignNodes = $data['national_nodes'];
        $nationalNodes = $data['foreign_nodes'];

        foreach ($foreignNodes as $node) {
            $ips = explode(',', $node['ips']);
            foreach ($ips as $ip) {
                $ipId = $this->ipRepository->firstOrCreate([
                    'address' => $ip,
                ])->id;
                $createdNode = $this->nodeRepository->store([
                    'ip_id'            => $ipId,
                    'country_id'       => $node['country_id'],
                    'entity_id'        => $node['entity_id'],
                    'ministry_id'      => $node['ministry_id'],
                    'internet_link_id' => $node['internet_link_id'],
                ]);
                $event->nodes()->attach($createdNode->id, ['is_source' => !$data['national_as_source']]);
            }
        }

        foreach ($nationalNodes as $node) {
            $ips = explode(',', $node['ips']);
            foreach ($ips as $ip) {
                $ipId = $this->ipRepository->firstOrCreate([
                    'address' => $ip,
                ])->id;
                $createdNode = $this->nodeRepository->store([
                    'ip_id'            => $ipId,
                    'country_id'       => country::where('name', 'Cuba')->first()->id,
                    'entity_id'        => $node['entity_id'],
                    'ministry_id'      => $node['ministry_id'],
                    'internet_link_id' => $node['internet_link_id'],
                ]);
                $event->nodes()->attach($createdNode->id, ['is_source' => $data['national_as_source']]);
            }
        }
    }

    public function update($data, $id)
    {
        $event = $this->entity->findOrFail($id);
        $event->update($data);

        $foreignNodes = $data['foreign_nodes'];
        $nationalNodes = $data['national_nodes'];
        $deletedNodes = $data['deleted_nodes'];

        // Remove nodes
        foreach ($deletedNodes as $nodeIp) {
            $event->nodes()->detach($nodeIp);
        }

        foreach ($foreignNodes as $node) {
            if ($node['ip_id'] ?? false || in_array($node['ip_id'] ?? null, $deletedNodes)) {
                continue;
                // TODO: cuando se permita modificar el nodo desde el evento, hacer el update desde aqui.
            } else {
                $ips = explode(',', $node['ips']);
                foreach ($ips as $ip) {
                    $ipId = $this->ipRepository->firstOrCreate([
                        'address' => $ip,
                    ])->id;
                    $createdNode = $this->nodeRepository->store([
                        'ip_id'            => $ipId,
                        'country_id'       => $node['country_id'],
                        'entity_id'        => $node['entity_id'],
                        'ministry_id'      => $node['ministry_id'],
                        'internet_link_id' => $node['internet_link_id'],
                    ]);
                    $event->nodes()->attach($createdNode->id, ['is_source' => !$data['national_as_source']]);
                }
            }
        }

        foreach ($nationalNodes as $node) {
            if ($node['ip_id'] ?? false || in_array($node['ip_id'] ?? null, $deletedNodes)) {
                continue;
                // TODO: cuando se permita modificar el nodo desde el evento, hacer el update desde aqui.
            } else {
                $ips = explode(',', $node['ips']);
                foreach ($ips as $ip) {
                    $ipId = $this->ipRepository->firstOrCreate([
                        'address' => $ip,
                    ])->id;
                    $createdNode = $this->nodeRepository->store([
                        'ip_id'            => $ipId,
                        'country_id'       => country::where('name', 'Cuba')->first()->id,
                        'entity_id'        => $node['entity_id'],
                        'ministry_id'      => $node['ministry_id'],
                        'internet_link_id' => $node['internet_link_id'],
                    ]);
                    $event->nodes()->attach($createdNode->id, ['is_source' => $data['national_as_source']]);
                }
            }
        }
    }

    public function getTotalByMonth($params)
    {
        $monthLabels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

        $startYear = date('Y', strtotime($params['startDate']));
        $endYear = date('Y', strtotime($params['endDate']));

        $labels = [];
        $totals = [];
        if ($startYear === $endYear) {
            $startMonth = (int) date('n', strtotime($params['startDate']));
            $endMonth = (int) date('n', strtotime($params['endDate']));

            while ($startMonth <= $endMonth) {
                $labels[] = $monthLabels[$startMonth - 1];
                $num_days = cal_days_in_month(CAL_GREGORIAN, $startMonth, $startYear);
                $startDate = date('1/'.$startMonth.'/'.$startYear);
                $endDate = date($num_days.'/'.$startMonth.'/'.$endYear);

                $query = $this->entity->whereBetween('date', [
                    Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d').' 00:00',
                    Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d').' 23:59',
                ]);
                $totals[] = $query->get()->count();
                $startMonth++;
            }
        } else {
            while ($startYear <= $endYear) {
                $labels[] = $startYear;
                $startDate = date('1/1/'.$startYear);
                $endDate = date('12/31/'.$startYear);

                $query = $this->entity->whereBetween('date', [
                    Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d').' 00:00',
                    Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d').' 23:59',
                ]);

                $totals[] = $query->get()->count();
                $startYear++;
            }
        }

        return [$totals, $labels];
    }

    public function getTotalsByEntities($params)
    {
        $monthLabels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        $startYear = date('Y', strtotime($params['startDate']));
        $endYear = date('Y', strtotime($params['endDate']));

        $entities = DB::table('entities')
            ->select('name', 'id')
            ->groupBy('name')->get();

        $labels = [];
        $totals = [];

        if ($startYear === $endYear) {
            $startMonth = (int) date('n', strtotime($params['startDate']));
            $endMonth = (int) date('n', strtotime($params['endDate']));

            while ($startMonth <= $endMonth) {
                $labels[] = $monthLabels[$startMonth - 1];
                $num_days = cal_days_in_month(CAL_GREGORIAN, $startMonth, $startYear);
                $startDate = date('1/'.$startMonth.'/'.$startYear);
                $endDate = date($num_days.'/'.$startMonth.'/'.$endYear);

                foreach ($entities as $entity) {
                    $query = $this->entity->where('detected_by_id', 'like', $entity->id);

                    $totals[$entity->name][] = $query->whereBetween('date', [
                        Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d').' 00:00',
                        Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d').' 23:59',
                    ])->get()->count();
                }

                $startMonth++;
            }

        } else {
            while ($startYear <= $endYear) {
                $labels[] = $startYear;
                $startDate = date('1/1/'.$startYear);
                $endDate = date('12/31/'.$startYear);

                foreach ($entities as $entity) {
                    $query = $this->entity->where('detected_by_id', 'like', $entity->id);

                    $totals[$entity->name][] = $query->whereBetween('date', [
                        Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d').' 00:00',
                        Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d').' 23:59',
                    ])->get()->count();
                }

                $totals[] = $query->get()->count();
                $startYear++;
            }
        }

        return [$totals, $labels];
    }

    public function getTotalsByCategories($params)
    {
        $starDate = date('Y-m-d', strtotime($params['startDate']));
        $endDate = date('Y-m-d', strtotime($params['endDate']));

        $labels = [];
        $totals = [];

        $results = $this->entity->query()->join('categories', function ($join) {
            $join->on('events.category_id', '=', 'categories.id');
        })->whereBetween('date',
            [$starDate, $endDate])->selectRaw('COUNT(categories.id) as count')->selectRaw('categories.name')
            ->groupBy('categories.name')->orderBy('count', 'desc')->get();

        foreach ($results as $data) {
            $totals[] = $data->count;
            $labels[] = $data->name;
        }

        return [$totals, $labels];
    }

    public function getExportQuery($sortBy = 'id', $sortDir = 'desc')
    {
        $query = $this->entity->with('nodes', 'nodes.ip');

        // if column categories
        $query->join('categories', function ($join) {
            $join->on('events.category_id', '=', 'categories.id');
        });

        // if column subcategories
        $query->join('subcategories', function ($join) {
            $join->on('events.subcategory_id', '=', 'subcategories.id');
        });

        // if column detectedBy
        $query->join('entities as detectedBy', function ($join) {
            $join->on('events.detected_by_id', '=', 'detectedBy.id');
        });

        // if column contributes
        $query->join('contributes', function ($join) {
            $join->on('events.contribute_id', '=', 'contributes.id');
        });


        return $query->select(
            'events.id',
            'date',
            'number',
            'categories.name as category_name',
            'subcategories.name as subcategory_name',
            'observations',
            DB::raw('CASE events.national_as_source = 1 WHEN true THEN "Origen" ELSE "Destino" END as `is_national_source`'),
            'detectedBy.name as detected_by_name',
            'contributes.name as contribute_name',
        )
            ->orderBy($sortBy, $sortDir)
            ->get();
    }
}
