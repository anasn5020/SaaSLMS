<?php

namespace App\Repositories\Interfaces;

interface GeneralSettingsInterface
{
    public function defaultSettings(): object;
    public function currencies(object $request): object;
    public function timezones(object $request): object;
    public function countries(object $request): object;
    public function states(object $request): object;
    public function cities(object $request): object;
}
