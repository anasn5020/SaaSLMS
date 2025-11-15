<?php

namespace App\Repositories\Interfaces;

interface ChapterRepositoryInterface
{
    public function chapters(object $request): object;
    public function update(object $request): bool;
    public function create(object $request): bool;
    public function delete(object $request): bool;
    public function contents(object $request): object;
    public function rearrangeContents(object $request): bool;
}
