<?php

namespace App\Repositories\Interfaces;

interface FilepondRepositoryInterface
{
    function load(object $request): mixed;
    function upload(object $request): array|string;
    function chunk(object $request): bool;
    function delete(object $request): bool;
}
