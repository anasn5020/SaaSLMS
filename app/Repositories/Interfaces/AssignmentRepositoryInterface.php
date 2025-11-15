<?php

namespace App\Repositories\Interfaces;

interface AssignmentRepositoryInterface
{
    public function store(object $request): bool;
    public function assignmentList(object $request): object;
    public function assignmentDetail(object $request): object;
    public function assignmentUpdate(object $request): bool;
    public function deleteChapterAssignment(object $request): bool;
}
