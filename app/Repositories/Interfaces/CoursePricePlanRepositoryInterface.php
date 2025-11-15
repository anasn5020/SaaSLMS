<?php

namespace App\Repositories\Interfaces;

interface CoursePricePlanRepositoryInterface
{
    public function storePlan(object $request): bool;
    public function updatePlan(object $request): bool;
    public function deletePlan(object $request): bool;
    public function virtualClassPricePlans(object $request): object;
}
