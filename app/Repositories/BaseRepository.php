<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IBaseRepository
{
    public $model;
    protected $filterAtrributes;

    public function __construct(Model $model, array $filterAtrributes)
    {
        $this->model = $model;
        $this->filterAtrributes = $filterAtrributes;
    }

    public function list(array $params) {
        $query = $this->model;
        foreach($params as $key => $val) {
            if ($key === 'sort') {
                $sortVal = explode(',', $val);
                $sortVal[1] = $sortVal[1] ?? 'asc';
                $query = $query->orderBy($sortVal[0], $sortVal[1]);
            } else {
                if (in_array($key, $this->filterAtrributes)) {
                    $query = $query->where($key, $val);
                }
            }
        }

        return $query;
    }

    public function find(string $id) {
        return $this->model->findOrFail($id);
    }

    public function findWithReference(string $id, string $referenceType, string $referenceValue) {
        $query['id'] = $id;
        $query[$referenceType] = $referenceValue;
        return $this->model->where($query)->firstOrFail();
    }

    public function create(array $attributes) {
        return $this->model->create($attributes);
    }

    public function update(string $id, array $attributes) {
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    public function delete(string $id) {
        return $this->model->destroy($id);
    }
}
