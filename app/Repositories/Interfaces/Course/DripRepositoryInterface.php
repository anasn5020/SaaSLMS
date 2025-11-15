<?php

namespace App\Repositories\Interfaces\Course;

interface DripRepositoryInterface
{
    function index(object $request, ?int $id): object;
    function update(object $request, ?int $id): bool;
}
