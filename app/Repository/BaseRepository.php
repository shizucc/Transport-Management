<?php

namespace App\Repository;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;
use Exception;

abstract class BaseRepository 
{
    protected Model $model;
    protected array $filterable = [];
    protected string $resourceName = 'Data';

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }
    public function newQuery(): BaseBuilder
    {
        return $this->model->builder();
    }

    public function getFilterable(): array 
    {
        return $this->filterable;
    }

    public function applyFilters(array $filters): Model
    {
        foreach ($filters as $field => $value) {
            if (!array_key_exists($field, $this->filterable) || $value === null || $value === '') {
                continue;
            }

            $type = $this->filterable[$field];

            switch ($type) {
                case 'like':
                    $this->model->like($field, $value);
                    break;
                case 'date':
                    $this->model->where("DATE({$field})", $value);
                    break;
                default:
                    $this->model->where($field, $value);
                    break;
            }
        }

        return $this->model;
    }

    public function paginate(int $perPage = 10, array $filters = [], string $group = 'default'): array
    {
        if (!empty($filters)) {
            $this->applyFilters($filters);
        }

        return [
            'data'  => $this->model->paginate($perPage, $group),
            'pager' => $this->model->pager,
        ];
    }

    public function create(array $data)
    {
        $this->model->insert($data);
        return $this->model->getInsertID();
    }

    public function find(int|string $id)
    {
        $result = $this->model->find($id);
        
        if (!$result) {
            throw new Exception("{$this->resourceName} with ID {$id} not found");
        }
        
        return $result;
    }

    public function update(int|string $id, array $data)
    {
        $this->find($id); 
        
        $this->model->update($id, $data);
        
        return $this->model->find($id); 
    }
    public function delete(int|string $id): bool
    {
        try {
            $this->find($id);
            return $this->model->delete($id);
        } catch (Exception $e) {
            throw new Exception("Failed to delete {$this->resourceName}: " . $e->getMessage());
        }
    }
}