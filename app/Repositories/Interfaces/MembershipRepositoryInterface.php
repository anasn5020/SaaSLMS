<?php

namespace App\Repositories\Interfaces;

interface MembershipRepositoryInterface
{
    function levels(object $request): object;
    function members(object $request): object;
}
