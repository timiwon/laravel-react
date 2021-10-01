<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection as Collection;
use App\Repositories\IBaseRepository;
use App\Http\Resources\BaseResource;

class BaseService implements IBaseService
{
    protected $repo;

    public function __construct(IBaseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $attributes): BaseResource
    {
        return new BaseResource($this->repo->create($attributes));
    }

    public function update(string $id, array $attributes): BaseResource
    {
        return new BaseResource($this->repo->update($id, $attributes));
    }

    public function list(array $params, int $perPage): Collection
    {
        return BaseResource::collection(
            $this->repo->list($params)->paginate($perPage)
        );
    }

    public function find(string $id): ?BaseResource
    {
        return new BaseResource($this->repo->find($id));
    }

    public function findWithReference(string $id, string $referenceType, string $referenceValue): ?BaseResource
    {
        return new BaseResource(
            $this->repo->findWithReference($id, $referenceType, $referenceValue)
        );
    }

    public function delete(string $id)
    {
        return $this->repo->delete($id);
    }

    public function deleteWithReferenceValidation(string $id, string $referenceType, string $referenceValue)
    {
        $item = $this->repo->findWithReference($id, $referenceType, $referenceValue);
        return $item->delete();
    }
}
