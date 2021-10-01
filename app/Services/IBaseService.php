<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection as Collection;
use App\Http\Resources\BaseResource;

interface IBaseService
{
    public function create(array $attributes): BaseResource;

    public function update(string $id, array $attributes): BaseResource;

    public function list(array $params, int $perPage): Collection;

    public function find(string $id): ?BaseResource;

    public function findWithReference(string $id, string $referenceType, string $referenceValue): ?BaseResource;

    public function delete(string $id);

    public function deleteWithReferenceValidation(string $id, string $referenceType, string $referenceValue);
}
