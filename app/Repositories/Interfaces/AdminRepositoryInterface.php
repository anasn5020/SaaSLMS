<?php

namespace App\Repositories\Interfaces;

interface AdminRepositoryInterface
{
    public function studentList(object $request): object;
    public function changeStudentStatus(object $request): bool;
    public function studentDetail(object $request): object;
    public function dashboard(): array;
}
