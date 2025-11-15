<?php

namespace App\Repositories\Interfaces;

interface CourseExerciseRepositoryInterface
{
    public function store(object $request): bool|object;
    public function update(object $request): bool|object;
    public function delete(object $request): object;
}
