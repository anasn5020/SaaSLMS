<?php

namespace App\Repositories\Interfaces;

interface ZoomRepositoryInterface
{
    public function configure(object $request): bool;
    public function settings(object $request): bool;
    public function getConfigSetting(): object;
    public function approvelTypes(): array;
    public function autoRecordings(): array;
    public function audios(): array;
    public function packages(): array;
}
