<?php

namespace App\Repositories\Interfaces;

interface VirtualClassRepositoryInterface
{
    public function store(object $request): bool;
    public function instructors(object $request): object;
    public function certificateTypes(): object;
    public function classList(object $request): object;
    public function classDetail(object $request): object;
    public function classSchedules(object $request): object;
    public function updateClass(object $request): bool;
    public function changeStatus(object $request): bool;
    public function deleteClass(object $request): bool;
    public function deleteSchedule(object $request): bool;
    public function addPricePlan(object $request): bool;
    public function deletePricePlan(object $request): bool;
    public function updatePricePlan(object $request): bool;
}
