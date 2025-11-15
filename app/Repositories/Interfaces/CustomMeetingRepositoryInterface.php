<?php

namespace App\Repositories\Interfaces;

interface CustomMeetingRepositoryInterface
{
    function update(object $request): bool;
}
