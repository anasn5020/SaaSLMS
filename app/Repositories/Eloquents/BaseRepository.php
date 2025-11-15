<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function allActive(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->where('status', 1)->get($columns);
    }

    public function allInActive(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->where('status', 0)->get($columns);
    }

    public function allWithPaginate(int $parPage = 20, array $relations = []): object
    {
        return $this->model->with($relations)->paginate($parPage);
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function getByCondition(array $condition, array $relations = [], array $columns = ['*']): Collection
    {
        return $this->model->where($condition)->with($relations)->get($columns);
    }

    public function findById(
        int   $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        if ($model) {
            $this->successMsg();
        }
        return $model->fresh();
    }

    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);
        $result = $model->update($payload);
        if ($result) {
            $this->successMsg();
        }
        return $result;
    }

    public function deleteById(int $modelId): bool
    {
        if (property_exists($this, 'deleteAble')) {
            $this->deleteAble($modelId);
        }
        $result = $this->findById($modelId)->delete();
        if ($result) {
            $this->successMsg();
        }
        return $result;
    }

    public function allInArray($key = 'id', $value = 'name'): array
    {
        return $this->model::pluck($value, $key)->toArray();
    }

    public function allActiveInArray($key = 'id', $value = 'name'): array
    {
        return $this->model::where('status', 1)->pluck($value, $key)->toArray();
    }

    protected function successMsg()
    {
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
    }
}
