<?php

namespace App\Models\Shared\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class SharedRepositoryEloquent implements SharedRepositoryInterface
{
    /**@var Model $entity */
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function find($id)
    {
        return $this->entity->find($id);
    }

    public function findOrFail($id, $with = [])
    {
        return $this->entity->with($with)->findOrFail($id);
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->entity->firstOrCreate($attributes);
    }

    public function all()
    {
        return $this->entity->all();
    }

    public function getAll($sortBy, $sortDir, $perPage, $page, $relationships = null) {

        return $relationships != null
            ? $this->entity->with($relationships)->orderBy($sortBy, $sortDir)->paginate($perPage, ['*'], 'page', $page)->toArray()
            : $this->entity->orderBy($sortBy, $sortDir)->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    public function store($fields)
    {
        return $this->entity->create($fields);
    }

    public function update($fields, $id)
    {
        $entity = $this->entity->findOrFail($id);

        return $entity->update($fields);
    }

    public function delete($id)
    {
        return $this->entity->destroy($id);
    }

    /** @return int */
    public function count(): int
    {
        return $this->entity->count();
    }

    public function getDataByDateRange($dateRange, $dateField = 'created_at') {
        $startDate = Carbon::parse($dateRange['startDate'] ?? null)->startOfDay();
        $endDate = Carbon::parse($dateRange['endDate'] ?? null)->endOfDay();
        dd($startDate, $endDate);
        return $this->entity->whereBetween($dateField, [$startDate, $endDate])->get();
    }
}
