<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function allActive(array $columns = ['*'], array $relations = []): Collection;

    public function allInActive(array $columns = ['*'], array $relations = []): Collection;

    public function allWithPaginate(int $parPage, array $relations = []): object;

    public function count(): int;

    public function getByCondition(array $condition, array $relations = [], array $columns = ['*']): Collection;


    public function findById(
        int   $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;


    public function create(array $payload): ?Model;


    public function update(int $modelId, array $payload): bool;

    public function deleteById(int $modelId): bool;

    public function allInArray(string $key, string $name): array;

    public function allActiveInArray(string $key, string $name): array;
}
