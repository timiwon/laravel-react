<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableStoreRequest;
use App\Http\Requests\TableIndexRequest;
use App\Http\Requests\TableUpdateRequest;
use App\Http\Requests\TableCombineRequest;
use App\Http\Requests\TableAssignToAreaRequest;
use App\Services\TableService;
use App\Models\Table;

class TableController extends Controller
{
    protected $service;

    public function __construct(TableService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TableIndexRequest $request, string $areaId)
    {
        $this->authorize('viewAny', [Table::class, $areaId]);

        $params = $request->validated();
        $params['area_id'] = $areaId;
        return $this->service->list($params, $params['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TableStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableStoreRequest $request, $areaId)
    {
        $this->authorize('create', [Table::class, $areaId]);
        return $this->service->createOnArea($areaId, $request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $areaId, string $tableId)
    {
        $this->authorize('view', [Table::class, $areaId, $tableId]);
        return $this->service->findWithCombinations($areaId, $tableId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TableUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(
        TableUpdateRequest $request,
        string $areaId,
        string $tableId,
    ) {
        $this->authorize('update', [Table::class, $areaId, $tableId]);
        $attributes = $request->validated();
        return $this->service->updateOnArea(
            $attributes,
            $areaId,
            $tableId
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $areaId, string $tableId)
    {
        $this->authorize('delete', [Table::class, $areaId, $tableId]);
        $this->service->deleteTable($tableId, 'area_id', $areaId);
    }

    public function assignToArea(
        TableAssignToAreaRequest $request,
        string $areaId,
        string $tableId
    ) {
        $attributes = $request->validated();
        $this->authorize('assignToArea', [Table::class, $areaId, $tableId, $attributes['area_id']]);

        $table = $this->service->assignToArea(
            $tableId,
            $areaId,
            $attributes['area_id']
        );
        return $table;
    }

    public function combineTables(
        TableCombineRequest $request,
        string $areaId,
        string $tableId
    ) {
        $attributes = $request->validated();
        $this->authorize('combineTables', [Table::class, $areaId, $tableId]);

        $table = $this->service->combineTables(
            $tableId,
            $attributes['table_ids'],
            $areaId,
        );
        return $table;
    }
}
