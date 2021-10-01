<?php

namespace App\Repositories;

interface IBaseRepository
{
    public function list(array $params);

    public function find(string $id);

    public function findWithReference(string $id, string $referenceType, string $referenceValue);

    public function create(array $attributes);

    public function update(string $id, array $attributes);

    public function delete(string $id);
}
