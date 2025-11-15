<?php

namespace App\Repositories\Interfaces;

interface LanguageRepositoryInterface
{
    public function languages(object $request): object;
    public function setLanguage(object $request): string;
    public function authLang(object $request): object;
}
