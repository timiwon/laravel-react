<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\TableRepository;
use App\Repositories\AreaRepository;

class TableService extends BaseService
{
    protected $areaRepo;

    public function __construct(
        TableRepository $repo,
        AreaRepository $areaRepo
    ) {
        parent::__construct($repo);
        $this->areaRepo = $areaRepo;
    }

    public function findWithCombinations(string $areaId, string $id): ?BaseResource
    {
        return new BaseResource(
            $this->repo->findWithCombinations($areaId, $id)
        );
    }

    public function createOnArea(string $areaId, array $attributes)
    {
        $area = $this->areaRepo->find($areaId);
        return new BaseResource($area->tables()->create($attributes));
    }

    public function updateOnArea(array $attributes, string $areaId, string $tableId)
    {
        $table = $this->repo->findWithReference($tableId, 'area_id', $areaId);
        $table->fill($attributes);
        $table->save();
        return new BaseResource($table);
    }

    public function assignToArea(string $tableId, string $oldAreaId, string $newAreaId)
    {
        $table = $this->repo->find($tableId);
        if ($table->area_id != $oldAreaId) {
            abort(404, 'table does not belong to area');
        }

        $table->area()->associate($newAreaId);
        $table->save();
        return new BaseResource($table);
    }

    public function combineTables(string $tableId, array $combinatedTableIds, string $areaId)
    {
        $table = $this->repo->find($tableId);
        if ($table->area_id != $areaId) {
            abort(404, 'table does not belong to area');
        }

        if ($table->type != 'combination') {
            abort(400, 'table is not combination type');
        }

        if (!$this->repo->isTablesInSameArea($areaId, $combinatedTableIds)) {
            abort(400, 'combined table are not in the same area');
        }

        foreach ($combinatedTableIds as $id) {
            $table->combinations()->attach($id);
        }
        return new BaseResource($table);
    }
}
