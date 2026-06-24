<?php

namespace App\Services;

use App\Repository\BaseRepository;

abstract class BaseService
{
    protected BaseRepository $repository;

    public function count(){
        return $this->repository->count();
    }

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginated(array $filters = [], int $limit = 10)
    {
        return $this->repository->paginate($limit, $filters);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}