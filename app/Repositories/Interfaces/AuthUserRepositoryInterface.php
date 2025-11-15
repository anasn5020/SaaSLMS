<?php

namespace App\Repositories\Interfaces;

interface AuthUserRepositoryInterface
{
    public function basicInfoUpdate(object $request): bool;
    public function aboutUpdate(object $request): bool;
    public function educationStore(object $request): bool;
    public function educationUpdate(object $request): bool;
    public function educationDestroy(object $request): bool;
    public function experienceStore(object $request): bool;
    public function experienceUpdate(object $request): bool;
    public function experienceDestroy(object $request): bool;
    public function skillStore(object $request): bool;
    public function extraInfoUpdate(object $request): bool;
    public function documentUpdate(object $request): bool;
    public function socialInfoUpdate(object $request): bool;
}
